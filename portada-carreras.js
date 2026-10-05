/* portada-carreras.js — aplica en la portada los textos editados de las 39
   tarjetas de programas (nombre, título corto y descripción), desde textos.json.
   El slug sale del enlace «Ver más» de cada tarjeta. Si no hay override, queda
   el texto original del HTML. Solo se carga en index.html. */
(function () {
  fetch('textos.json', { cache: 'no-store' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (t) {
      if (!t) return;
      document.querySelectorAll('.carreras-grid .carrera').forEach(function (card) {
        var a = card.querySelector('a[href*="carreras/"]');
        if (!a) return;
        var mm = (a.getAttribute('href') || '').match(/carreras\/(.+?)\.html/);
        if (!mm) return;
        var d = t[mm[1]];
        if (!d) return;
        if (d.nombre) { var h3 = card.querySelector('h3'); if (h3) h3.textContent = d.nombre; }
        if (d.portada_fac) { var fac = card.querySelector('.fac'); if (fac) fac.textContent = d.portada_fac; }
        if (d.portada_desc) { var p = card.querySelector('.carrera-cuerpo p'); if (p) p.textContent = d.portada_desc; }
      });
    })
    .catch(function () { /* silencio: quedan los textos del HTML */ });
})();
