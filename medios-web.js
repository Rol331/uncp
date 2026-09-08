/* medios-web.js — aplica en el sitio las imágenes que el usuario cambió desde
   el panel (/admin → Carreras). Lee medios.json y reemplaza banner, tarjeta y
   galería de cada carrera. El slug se deduce de la propia URL de la imagen, así
   no hace falta tocar el HTML. Si no hay medios.json, quedan las fotos originales. */
(function () {
  var enSub = location.pathname.indexOf('/carreras/') !== -1;
  var pre = enSub ? '../' : ''; // las páginas de carrera están en /carreras/

  fetch(pre + 'medios.json', { cache: 'no-store' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (m) {
      if (!m) return;

      // Tarjetas de la portada: <div class="carrera-img" style="background-image:url(imagenes/tarjetas/SLUG.jpg)">
      if (m.tarjetas) {
        document.querySelectorAll('.carrera-img').forEach(function (el) {
          var slug = slugDe(el.style.backgroundImage, 'tarjetas');
          if (slug && m.tarjetas[slug]) el.style.backgroundImage = "url('" + pre + m.tarjetas[slug] + "')";
        });
      }

      // Banner de la carrera: <div class="banner-interior-bg" style="background-image:url(../imagenes/banner/SLUG.jpg)">
      if (m.banner) {
        document.querySelectorAll('.banner-interior-bg').forEach(function (el) {
          var slug = slugDe(el.style.backgroundImage, 'banner');
          if (slug && m.banner[slug]) el.style.backgroundImage = "url('" + pre + m.banner[slug] + "')";
        });
      }

      // Galería: <img src="../imagenes/galeria/SLUG-N.jpg">
      if (m.galeria) {
        document.querySelectorAll('.galeria img').forEach(function (img) {
          var mt = (img.getAttribute('src') || '').match(/galeria\/(.+)-(\d+)\.(?:jpg|jpeg|png)/i);
          if (mt && m.galeria[mt[1]] && m.galeria[mt[1]][mt[2]]) {
            img.setAttribute('src', pre + m.galeria[mt[1]][mt[2]]);
          }
        });
      }
    })
    .catch(function () { /* silencio: se quedan las imágenes del HTML */ });

  function slugDe(bg, carpeta) {
    var mt = (bg || '').match(new RegExp(carpeta + '\\/(.+?)\\.(?:jpg|jpeg|png)', 'i'));
    return mt ? mt[1] : null;
  }
})();
