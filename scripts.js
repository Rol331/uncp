/* ===========================================================
   SCRIPTS COMPARTIDOS — Landing Pregrado UNCP
   Header con scroll, menú móvil, submenú de carreras
   y animaciones al hacer scroll.
============================================================ */

/* ===== HEADER al hacer scroll ===== */
const header = document.getElementById('header');
if(header){
  const alScroll = ()=> header.classList.toggle('scrolled', window.scrollY > 60);
  window.addEventListener('scroll', alScroll);
  alScroll();
}

/* ===== MENÚ MÓVIL ===== */
const hamburguesa = document.getElementById('hamburguesa');
const menu = document.getElementById('menu');

function cerrarSubmenus(){
  document.querySelectorAll('.tiene-sub').forEach(s=>{
    s.classList.remove('abierto');
    const b = s.querySelector('.enlace-sub');
    if(b) b.setAttribute('aria-expanded','false');
  });
}

if(hamburguesa && menu){
  hamburguesa.addEventListener('click', ()=>{
    hamburguesa.classList.toggle('activa');
    menu.classList.toggle('abierto');
    if(!menu.classList.contains('abierto')) cerrarSubmenus();
  });
  // al elegir un enlace se cierra el menú lateral (el botón del submenú no es <a>)
  menu.querySelectorAll('a').forEach(a=>{
    a.addEventListener('click', ()=>{
      hamburguesa.classList.remove('activa');
      menu.classList.remove('abierto');
      cerrarSubmenus();
    });
  });
}

/* ===== SUBMENÚ DE CARRERAS (clic en escritorio y móvil) ===== */
document.querySelectorAll('.tiene-sub').forEach(item=>{
  const boton = item.querySelector('.enlace-sub');
  if(!boton) return;
  boton.addEventListener('click', (e)=>{
    e.preventDefault();
    e.stopPropagation();
    const estabaAbierto = item.classList.contains('abierto');
    cerrarSubmenus();
    if(!estabaAbierto){
      item.classList.add('abierto');
      boton.setAttribute('aria-expanded','true');
    }
  });
});
document.addEventListener('click', (e)=>{
  if(!e.target.closest('.tiene-sub')) cerrarSubmenus();
});
document.addEventListener('keydown', (e)=>{
  if(e.key === 'Escape') cerrarSubmenus();
});

/* ===== ANIMACIÓN AL HACER SCROLL (IntersectionObserver) ===== */
const observador = new IntersectionObserver((entradas)=>{
  entradas.forEach(entrada=>{
    if(entrada.isIntersecting){
      entrada.target.classList.add('visible');
      // contador animado si aplica
      if(entrada.target.classList.contains('stat')){
        animarContador(entrada.target.querySelector('[data-cuenta]'));
      }
      observador.unobserve(entrada.target);
    }
  });
}, {threshold:0.15});

document.querySelectorAll('.revelar').forEach(el=> observador.observe(el));

/* ===== CONTADOR ANIMADO ===== */
function animarContador(el){
  if(!el) return;
  const destino = +el.dataset.cuenta;
  const duracion = 1600;
  const inicio = performance.now();
  function paso(ahora){
    const avance = Math.min((ahora - inicio)/duracion, 1);
    const valor = Math.floor(avance * destino);
    // el sufijo lo define el HTML con data-sufijo ("+", "%" o nada)
    el.textContent = valor.toLocaleString('es-PE') + (avance===1 ? (el.dataset.sufijo || '') : '');
    if(avance < 1) requestAnimationFrame(paso);
  }
  requestAnimationFrame(paso);
}

/* ===== VISOR DE LA GALERÍA (clic en una foto = se amplía) ===== */
const visor = document.getElementById('visor');
if(visor){
  const visorImg = document.getElementById('visorImg');
  const cerrarBtn = document.getElementById('visorCerrar');

  function abrirVisor(img){
    visorImg.src = img.currentSrc || img.src;
    visorImg.alt = img.alt || '';
    visor.classList.add('abierto');
    document.body.style.overflow = 'hidden';
    cerrarBtn.focus();
  }
  function cerrarVisor(){
    visor.classList.remove('abierto');
    document.body.style.overflow = '';
    // se limpia al terminar la transición para que no parpadee
    setTimeout(()=>{ if(!visor.classList.contains('abierto')) visorImg.src = ''; }, 300);
  }

  document.querySelectorAll('.galeria img').forEach(img=>{
    img.addEventListener('click', ()=> abrirVisor(img));
  });
  cerrarBtn.addEventListener('click', cerrarVisor);
  visor.addEventListener('click', (e)=>{ if(e.target !== visorImg) cerrarVisor(); });
  document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape' && visor.classList.contains('abierto')) cerrarVisor();
  });
}
