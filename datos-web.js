/* datos-web.js — rellena en las páginas los valores administrables desde
   datos-admision.json (lo edita el panel /admin). Si el JSON no existe o el
   JavaScript está apagado, la página conserva los valores originales del HTML. */
(function () {
  fetch('datos-admision.json', { cache: 'no-store' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (d) {
      if (!d) return;

      // Documentos: cada <a data-doc="clave"> toma su enlace del JSON.
      var docs = d.documentos || {};
      document.querySelectorAll('[data-doc]').forEach(function (a) {
        var k = a.getAttribute('data-doc');
        if (docs[k]) a.setAttribute('href', docs[k]);
      });

      // Fechas de posgrado (Fase 2): cada elemento con data-fecha="clave".
      var fechas = d.posgrado_cronograma || {};
      document.querySelectorAll('[data-fecha]').forEach(function (el) {
        var k = el.getAttribute('data-fecha');
        if (fechas[k]) el.textContent = fechas[k];
      });
    })
    .catch(function () { /* silencio: se quedan los valores del HTML */ });
})();
