/* textos-web.js — aplica en cada página de carrera los textos que el usuario
   cambió desde el panel (/admin → Carreras). Lee textos.json y reemplaza la
   bajada, el perfil del egresado y el campo ocupacional. El slug se deduce de la
   URL. Si no hay textos.json o el campo está vacío, queda el texto original. */
(function () {
  var mt = location.pathname.match(/carreras\/(.+?)\.html/);
  if (!mt) return;
  var slug = mt[1];

  fetch('../textos.json', { cache: 'no-store' })
    .then(function (r) { return r.ok ? r.json() : null; })
    .then(function (t) {
      if (!t || !t[slug]) return;
      var d = t[slug];

      // Bajada del banner
      if (d.bajada) {
        var b = document.querySelector('.banner-interior .bajada');
        if (b) b.textContent = d.bajada;
      }

      // Perfil y campo ocupacional: se ubican por el rótulo del bloque.
      document.querySelectorAll('.carrera-detalle .bloque').forEach(function (bl) {
        var rot = (bl.querySelector('.rotulo') || {}).textContent || '';
        rot = rot.trim().toLowerCase();

        if (rot === 'perfil del egresado' && d.perfil) {
          var p = bl.querySelector('p');
          if (p) p.textContent = d.perfil;
        }

        if (rot === 'campo ocupacional' && Array.isArray(d.campo) && d.campo.length) {
          var ul = bl.querySelector('ul.lista-check');
          if (ul) {
            ul.innerHTML = '';
            d.campo.forEach(function (item) {
              var li = document.createElement('li');
              var marca = document.createElement('span');
              marca.className = 'marca-li';
              marca.innerHTML = '&#10003;';
              var txt = document.createElement('span');
              txt.textContent = item;
              li.appendChild(marca);
              li.appendChild(txt);
              ul.appendChild(li);
            });
          }
        }
      });
    })
    .catch(function () { /* silencio: se quedan los textos del HTML */ });
})();
