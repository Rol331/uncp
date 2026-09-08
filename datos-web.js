/* datos-web.js — rellena en las páginas los valores administrables desde
   datos-admision.json (lo edita el panel /admin). Si el JSON no existe o el
   JavaScript está apagado, la página conserva los valores originales del HTML. */
(function () {
  fetch('datos-admision.json', { cache: 'no-store' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (d) {
      if (!d) return;

      // Documentos de admisión: <a data-doc="clave"> toma su enlace del JSON.
      aplicar(d.documentos, 'data-doc', function (el, valor) {
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
