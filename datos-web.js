/* datos-web.js — rellena en las páginas los valores administrables desde
   datos-admision.json (lo edita el panel /admin). Si el JSON no existe o el
   JavaScript está apagado, la página conserva los valores originales del HTML. */
(function () {
  // Las páginas de carrera están en /carreras/, así que el JSON queda un nivel arriba.
  var pre = location.pathname.indexOf('/carreras/') !== -1 ? '../' : '';
  fetch(pre + 'datos-admision.json', { cache: 'no-store' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (d) {
      if (!d) return;

      // Documentos: <a data-doc="clave"> toma su enlace del JSON. Se juntan los de
      // admisión y los de resultados de posgrado (sus claves no se repiten).
      var docs = {};
      if (d.documentos) for (var a in d.documentos) docs[a] = d.documentos[a];
      if (d.posgrado_resultados) for (var b in d.posgrado_resultados) docs[b] = d.posgrado_resultados[b];
      aplicar(docs, 'data-doc', function (el, valor) {
        el.setAttribute('href', valor);
      });

      // Fechas de posgrado: <span data-fecha="clave"> toma su texto.
      aplicar(d.posgrado_cronograma, 'data-fecha', function (el, valor) {
        el.textContent = valor;
      });

      // Costos de posgrado: <span data-costo="clave"> toma su texto.
      aplicar(d.posgrado_costos, 'data-costo', function (el, valor) {
        el.textContent = valor;
      });

      // Portada y footer: textos por data-portada, enlaces por data-portada-href.
      if (d.portada) {
        aplicar(d.portada, 'data-portada', function (el, valor) {
          el.textContent = valor;
        });
        // Enlaces (redes sociales del footer, etc.).
        aplicar(d.portada, 'data-portada-href', function (el, valor) {
          el.setAttribute('href', valor);
        });
        // Números de las estadísticas.
        document.querySelectorAll('[data-portada-num]').forEach(function (el) {
          var k = el.getAttribute('data-portada-num');
          if (d.portada[k] !== undefined && d.portada[k] !== '') {
            el.setAttribute('data-cuenta', String(d.portada[k]).replace(/[^\d]/g, '') || '0');
            // Re-lanzar el contador: puede que ya se haya animado con el valor viejo.
            if (typeof window.animarContador === 'function') window.animarContador(el);
          }
        });
        // WhatsApp: reescribe el número en TODOS los enlaces wa.me del sitio
        // (footer y botón flotante). Si son 9 dígitos, se les antepone 51 (Perú).
        if (d.portada.footer_whatsapp) {
          var raw = String(d.portada.footer_whatsapp).replace(/\D/g, '');
          var num = raw.length === 9 ? '51' + raw : raw;
          if (num) {
            document.querySelectorAll('a[href*="wa.me/"]').forEach(function (a) {
              a.href = a.getAttribute('href').replace(/wa\.me\/\d+/, 'wa.me/' + num);
            });
          }
        }
      }
    })
    .catch(function () { /* silencio: se quedan los valores del HTML */ });

  function aplicar(mapa, attr, fn) {
    if (!mapa) return;
    document.querySelectorAll('[' + attr + ']').forEach(function (el) {
      var k = el.getAttribute(attr);
      if (mapa[k] !== undefined && mapa[k] !== '') fn(el, mapa[k]);
    });
  }
})();
