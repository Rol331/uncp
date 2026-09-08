/* datos-web.js — rellena en las páginas los valores administrables desde
   datos-admision.json (lo edita el panel /admin). Si el JSON no existe o el
   JavaScript está apagado, la página conserva los valores originales del HTML. */
(function () {
  fetch('datos-admision.json', { cache: 'no-store' })
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

      // Portada (index.html): textos y números de las estadísticas.
      if (d.portada) {
        aplicar(d.portada, 'data-portada', function (el, valor) {
          el.textContent = valor;
        });
        document.querySelectorAll('[data-portada-num]').forEach(function (el) {
          var k = el.getAttribute('data-portada-num');
          if (d.portada[k] !== undefined && d.portada[k] !== '') {
            el.setAttribute('data-cuenta', String(d.portada[k]).replace(/[^\d]/g, '') || '0');
            // Re-lanzar el contador: puede que ya se haya animado con el valor viejo.
            if (typeof window.animarContador === 'function') window.animarContador(el);
          }
        });
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
