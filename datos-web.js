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

      // Banners de páginas internas: textos (data-banner) y enlaces de botones (data-banner-href).
      aplicar(d.banners, 'data-banner', function (el, valor) { el.textContent = valor; });
      aplicar(d.banners, 'data-banner-href', function (el, valor) { el.setAttribute('href', valor); });

      // Títulos de sección de páginas internas: <span/h2/p data-sec="clave">.
      aplicar(d.secciones, 'data-sec', function (el, valor) { el.textContent = valor; });

      // Botones de las páginas de carrera (iguales en las 39): data-cbtn / data-cbtn-href.
      aplicar(d.carreras_botones, 'data-cbtn', function (el, valor) { el.textContent = valor; });
      aplicar(d.carreras_botones, 'data-cbtn-href', function (el, valor) { el.setAttribute('href', valor); });

      // SEO: título de pestaña y meta descripción según la página.
      if (d.seo) {
        var pg = {
          '': 'home', 'index.html': 'home', 'admision.html': 'adm', 'inscripcion.html': 'ins',
          'posgrado.html': 'pos', 'posgrado-cronograma.html': 'cro', 'posgrado-costos.html': 'cos',
          'prospecto.html': 'pro', 'resultados.html': 'res'
        }[location.pathname.split('/').pop()];
        if (pg) {
          if (d.seo[pg + '_title']) document.title = d.seo[pg + '_title'];
          if (d.seo[pg + '_desc']) {
            var md = document.querySelector('meta[name="description"]');
            if (md) md.setAttribute('content', d.seo[pg + '_desc']);
          }
        }
      }

      // Documentos: <a data-doc="clave"> toma su enlace del JSON. Se juntan los de
      // admisión y los de resultados de posgrado (sus claves no se repiten).
      var docs = {};
      if (d.documentos) for (var a in d.documentos) docs[a] = d.documentos[a];
      if (d.posgrado_resultados) for (var b in d.posgrado_resultados) docs[b] = d.posgrado_resultados[b];
      if (d.posgrado_documentos) for (var pd in d.posgrado_documentos) docs[pd] = d.posgrado_documentos[pd];
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

      // Costos de inscripción (pregrado): <span data-insc="clave">.
      aplicar(d.inscripcion_costos, 'data-insc', function (el, valor) {
        el.textContent = valor;
      });

      // Modalidades de inscripción: <span data-mod="clave">. La parte entre
      // paréntesis (Caja UNCP) se muestra en <small>.
      aplicar(d.inscripcion_modalidades, 'data-mod', function (el, valor) {
        var mt = String(valor).match(/^(.*?)\s*(\(.*\))\s*$/);
        el.textContent = '';
        if (mt) {
          el.appendChild(document.createTextNode(mt[1] + ' '));
          var s = document.createElement('small');
          s.textContent = mt[2];
          el.appendChild(s);
        } else {
          el.textContent = valor;
        }
      });

      // Modalidades de postulación (inscripcion.html): encabezado y descripciones.
      aplicar(d.modalidades_postulacion, 'data-modp', function (el, valor) {
        el.textContent = valor;
      });

      // Textos de las tarjetas de admisión: <h3/p data-doctxt="clave">.
      aplicar(d.admision_textos, 'data-doctxt', function (el, valor) {
        el.textContent = valor;
      });

      // Página de inscripción: textos por data-inscp y la lista de requisitos.
      if (d.inscripcion_pagina) {
        aplicar(d.inscripcion_pagina, 'data-inscp', function (el, valor) {
          el.textContent = valor;
        });
        aplicar(d.inscripcion_pagina, 'data-inscp-href', function (el, valor) {
          el.setAttribute('href', valor);
        });
        document.querySelectorAll('[data-inscp-lista]').forEach(function (ul) {
          var arr = d.inscripcion_pagina[ul.getAttribute('data-inscp-lista')];
          if (Array.isArray(arr) && arr.length) {
            ul.innerHTML = '';
            arr.forEach(function (item) {
              var li = document.createElement('li');
              var m = document.createElement('span'); m.className = 'marca-li'; m.innerHTML = '&#10003;';
              var s = document.createElement('span'); s.textContent = item;
              li.appendChild(m); li.appendChild(s);
              ul.appendChild(li);
            });
          }
        });
      }

      // Página del prospecto: checklist "qué encontrarás" y capítulos (acordeón).
      if (d.prospecto_pagina) {
        var pp = d.prospecto_pagina;
        if (Array.isArray(pp.pro_check) && pp.pro_check.length) {
          var ulc = document.querySelector('[data-pro-check]');
          if (ulc) {
            ulc.innerHTML = '';
            pp.pro_check.forEach(function (item) {
              var li = document.createElement('li');
              var m = document.createElement('span'); m.className = 'marca-li'; m.innerHTML = '&#10003;';
              var s = document.createElement('span'); s.textContent = item;
              li.appendChild(m); li.appendChild(s);
              ulc.appendChild(li);
            });
          }
        }
        for (var c = 1; c <= 4; c++) {
          var det = document.querySelector('[data-pro-cap="' + c + '"]');
          if (!det) continue;
          var tit = pp['pro_cap' + c + '_tit'];
          if (tit) { var ts = det.querySelector('[data-pro-cap-tit]'); if (ts) ts.textContent = tit; }
          var items = pp['pro_cap' + c + '_items'];
          if (Array.isArray(items) && items.length) {
            var cul = det.querySelector('[data-pro-cap-items]');
            if (cul) {
              cul.innerHTML = '';
              items.forEach(function (t) { var li = document.createElement('li'); li.textContent = t; cul.appendChild(li); });
            }
            var n = det.querySelector('.plan-n');
            if (n) n.textContent = items.length + (items.length === 1 ? ' tema' : ' temas');
          }
        }
      }

      // Ventana emergente (popup) de la portada.
      if (d.popup) {
        var modal = document.getElementById('modalPromo');
        if (modal) {
          var pTit = modal.querySelector('[data-pop="titulo"]');
          var pTxt = modal.querySelector('[data-pop="texto"]');
          var pBtn = modal.querySelector('[data-pop="btn"]');
          if (pTit) { if (d.popup.pop_titulo) pTit.textContent = d.popup.pop_titulo; else pTit.hidden = true; }
          if (pTxt) { if (d.popup.pop_texto) pTxt.textContent = d.popup.pop_texto; else pTxt.hidden = true; }
          if (pBtn) {
            if (d.popup.pop_btn_txt) pBtn.textContent = d.popup.pop_btn_txt; else pBtn.hidden = true;
            if (d.popup.pop_btn_link) pBtn.setAttribute('href', d.popup.pop_btn_link);
          }
          var cerrarPop = function () { modal.hidden = true; document.body.style.overflow = ''; };
          modal.querySelectorAll('[data-pop-cerrar]').forEach(function (b) { b.addEventListener('click', cerrarPop); });
          document.addEventListener('keydown', function (e) { if (e.key === 'Escape') cerrarPop(); });
          if (String(d.popup.pop_activo || '').trim().toLowerCase() === 'si') {
            var vista = false;
            try { vista = sessionStorage.getItem('promoVista') === '1'; } catch (e) {}
            if (!vista) {
              modal.hidden = false;
              document.body.style.overflow = 'hidden';
              try { sessionStorage.setItem('promoVista', '1'); } catch (e) {}
            }
          }
        }
      }

      // Portada y footer: textos por data-portada, enlaces por data-portada-href.
      if (d.portada) {
        aplicar(d.portada, 'data-portada', function (el, valor) {
          el.textContent = valor;
        });
        // Enlaces (redes sociales del footer, botones, etc.).
        aplicar(d.portada, 'data-portada-href', function (el, valor) {
          el.setAttribute('href', valor);
        });
        // Video institucional: del enlace/ID de Drive se arma la URL /preview.
        if (d.portada.video_id) {
          var vm = String(d.portada.video_id).match(/[-\w]{25,}/);
          var vid = vm ? vm[0] : '';
          var ifr = document.querySelector('[data-portada-video]');
          if (ifr && vid) ifr.src = 'https://drive.google.com/file/d/' + vid + '/preview';
        }
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
