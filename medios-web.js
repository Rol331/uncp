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

      // Portada: carrusel (3 .slide-bg) y tarjetas de acceso (4 .acceso), por orden.
      if (m.portada) {
        var bgs = document.querySelectorAll('.banner .slide .slide-bg');
        for (var s = 1; s <= 3; s++) {
          if (bgs[s - 1] && m.portada['slide' + s]) {
            bgs[s - 1].style.backgroundImage = "url('" + pre + m.portada['slide' + s] + "')";
          }
        }
        var acc = document.querySelectorAll('.accesos-grid .acceso');
        for (var a = 1; a <= 4; a++) {
          if (acc[a - 1] && m.portada['acceso' + a]) {
            acc[a - 1].style.backgroundImage = "url('" + pre + m.portada['acceso' + a] + "')";
          }
        }
      }

      // Galería de la carrera: hasta 4 fotos (override de medios o la original).
      var gal = document.querySelector('.galeria');
      if (gal) {
        var slugG = (location.pathname.match(/carreras\/(.+?)\.html/) || [])[1] || '';
        var existentes = [];
        gal.querySelectorAll('img').forEach(function (i) { existentes.push(i.getAttribute('src')); });
        var ov = (m.galeria && m.galeria[slugG]) || {};
        var urls = [];
        for (var g = 1; g <= 4; g++) {
          if (ov[g]) urls.push(pre + ov[g]);
          else if (existentes[g - 1]) urls.push(existentes[g - 1]);
        }
        var bloque = gal.closest ? gal.closest('.bloque') : null;
        if (urls.length === 0) {
          if (bloque) bloque.hidden = true;
        } else {
          if (bloque) bloque.hidden = false;
          gal.innerHTML = '';
          var altG = (document.title.split('|')[0] || '').trim();
          urls.forEach(function (u) {
            var fig = document.createElement('figure');
            var img = document.createElement('img');
            img.src = u; img.loading = 'lazy'; img.width = 800; img.height = 600; img.alt = altG;
            fig.appendChild(img);
            gal.appendChild(fig);
          });
        }
      }
    })
    .catch(function () { /* silencio: se quedan las imágenes del HTML */ });

  function slugDe(bg, carpeta) {
    var mt = (bg || '').match(new RegExp(carpeta + '\\/(.+?)\\.(?:jpg|jpeg|png)', 'i'));
    return mt ? mt[1] : null;
  }
})();
