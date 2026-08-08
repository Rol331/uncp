# CLAUDE.md — Landing Pregrado UNCP

Contexto del proyecto para Claude Code.

## Qué es

Landing page de **Pregrado de la Universidad Nacional del Centro del Perú (UNCP)**.
Página promocional/informativa con captación de leads (formulario de solicitud de información).

## Stack

- **HTML + CSS + JavaScript vanilla.**
- **Sin frameworks, sin build, sin dependencias.** Se abre directamente en el navegador.
- CSS y JS compartidos en archivos externos (`estilos.css`, `scripts.js`).

## Archivos

```
index.html          — portada / landing
admision.html       — Admisión 2026-II (documentos oficiales del proceso)
estilos.css         — CSS de TODAS las páginas
scripts.js          — JS compartido (header, menú móvil, submenú, .revelar, contador, visor de galería)
carreras/*.html     — 39 páginas de programa (una por programa de estudio)
imagenes/           — fotos optimizadas y versionadas
  portada/slide-N.jpg      1600x900  carrusel de la portada (3)
  banner/<slug>.jpg        1600x900  banner de cada programa (21)
  tarjetas/<slug>.jpg       600x400  tarjetas de #carreras en la portada (21)
  galeria/<slug>-N.jpg      800x600  galería de cada programa (50)
img-carreras/       — ORIGINALES sin optimizar, en .gitignore (~505 MB)
```

- `index.html` carga `estilos.css` + `scripts.js` y además tiene un `<script>` en línea solo
  para lo suyo (carrusel del banner y submit del formulario).
- Las páginas de `carreras/` y `admision.html` usan las mismas hojas compartidas.
- El header, el submenú y el footer están **duplicados en las 41 páginas**: no se editan a mano,
  se regeneran con los scripts de apoyo (ver *Regenerar*).

## Diseño

- Color principal (verde institucional): `#00301C`. Acento dorado: `#c9a24b`.
- Variables CSS en `:root` (`--verde-900`, `--dorado`, `--crema`, radios, sombras, transiciones).
- Tipografía del sistema (Segoe UI / system-ui).
- Responsive con `clamp()`, grid y menú hamburguesa móvil.

## Estructura de `index.html`

- **Header fijo** (`#header`) — cambia de estilo al hacer scroll (clase `.scrolled`).
- **Banner** (`#inicio`) — carrusel automático (6s) + formulario de captación (`#formInfo`:
  nombre, correo, teléfono, interés con los 39 programas en `optgroup` por área).
- **Stats** — contadores animados con `IntersectionObserver`. El `+` / `%` sale de `data-sufijo`
  (66 años y 39 programas van sin sufijo; 25 000 lleva `+` y 95 lleva `%`).
- **Programas** (`#carreras`) — los 39, agrupados por área, cada uno enlaza a su página.
- **Accesos de admisión** (`#accesos`) — 4 tarjetas con foto: Información 2026-II, Prospecto,
  Inscripción en línea y Resultados.
- **Por qué elegirnos** (`#porque`).
- **Video institucional** (`#video`) — iframe de Google Drive (`…/file/d/ID/preview`).
- **CTA Admisión** (`#admision`) — *Inscríbete aquí* y *Descargar prospecto*.
- **Footer** (`#contacto`) — con las redes sociales y el WhatsApp.
- **Botón flotante de WhatsApp** (`.wsp`) en todas las páginas.

## Submenú de programas (mega menú)

En el header, "Carreras" es un `<button class="enlace-sub">` dentro de `.tiene-sub`, con el panel
`.submenu` (**5 columnas, una por área**).

- **Escritorio:** se abre al pasar el mouse (`:hover`) o al hacer clic. El panel es
  `position:fixed` centrado en el viewport (`top:92px`, `66px` con `.scrolled`), así nunca se
  desborda. Un `::after` invisible en `.tiene-sub` hace de puente para que no se cierre al bajar
  el mouse. A ≤1320px pasa a 3 columnas y a ≤1100px a 2.
- **Móvil (≤768px):** el panel pasa a `position:static` y funciona como acordeón
  (`max-height` 0 → 60vh) dentro del menú lateral.
- Los programas de filial llevan `class="filial" data-filial="Filial Tarma|Satipo"`; el rótulo
  lo pinta el `::after` con `content:attr(data-filial)`.

## Estructura de una página de programa (`carreras/*.html`)

1. **Banner** (`.banner-interior`, `#inicio`) — miga de pan, etiqueta de área, `h1`, bajada, chips
   con Título/Grado y botones. La foto va en `background-image` de `.banner-interior-bg`, sobre
   ella cae el velo verde de `.banner-interior::before`.
2. **Información** (`#info`) — `.carrera-layout` (contenido + `aside.ficha` sticky) con cinco
   bloques: **Perfil del Egresado**, **Campo Ocupacional** (`.lista-check`), **Plan de estudios**
   (`.plan`, acordeón `<details>` por semestre), **Laboratorios** (`.labs`) y **Galería**
   (`.galeria`, 16:9, se amplía al hacer clic con el visor de `scripts.js`).
   Además queda un bloque de **plana docente** comentado, listo para llenar.
3. **Otros programas del área** (`#otras`).
4. **CTA Admisión** (`#admision`) + footer + botón de WhatsApp + visor de galería.

Los 39 programas salen de `INFORMACIÓN PARA PÁGINMA WEB.docx` y los planes de
`PLAN DE ESTUDIOS 2.docx`:
Área I Ciencias de la Salud (2) · Área II Arquitectura e Ingenierías (10) ·
Área III Ciencias Administrativas, Contables y Económicas (5, dos en Filial Tarma) ·
Área IV Ciencias Sociales y Educación (12) · Área V Ciencias Agrarias (10, una en Filial Tarma
y cuatro en Filial Satipo).

## Enlaces externos que usa el sitio

- Inscripción / *Solicitar información*: `https://erpadmision.uncp.edu.pe/inscripcion`
- Prospecto: `https://drive.google.com/file/d/1tqgMdpMqXMnMaxNtdWzaMPL4I5DOa6M0/view`
- WhatsApp: `https://wa.me/51939054663`
- Redes: `facebook.com/uncpadmisionoficial`, `instagram.com/admision_uncp`,
  `youtube.com/channel/UCzA77CCORqPaHkwLDgd9V_Q`, `tiktok.com/@uncp_admision`
- Video institucional: Google Drive `1Rn-Yk7NZe_N1LvkIGvM0d8KdtO_6hGCZ`
- Los documentos de `admision.html` (cronograma, reglamento, vacantes, temario, ponderaciones,
  costos, guías, baremos, voucher) apuntan a los Drive oficiales de `uncpadmision.edu.pe`.

## JavaScript

- `scripts.js` (compartido): header con scroll, menú móvil, submenú (`cerrarSubmenus`, clic fuera,
  `Escape`, `aria-expanded`), animaciones `.revelar` → `.visible`, contador animado y **visor de
  galería** (clic en la foto → overlay a pantalla completa; cierra con la X, clic fuera o `Escape`).
- En línea en `index.html`: carrusel del banner (`mostrar`/`irA`/`siguiente`/`anterior`) y submit
  del formulario.

## Regenerar

Los scripts de apoyo **no están versionados** (viven fuera del repo). Son tres y se ejecutan en
este orden:

1. `datos.py` — lee los dos `.docx` y escribe `programas.json` (39 programas con área, grado,
   título, perfil, campo ocupacional, laboratorios, filial, slug y plan de estudios).
2. `paginas.py` — genera las 39 páginas de `carreras/` y los fragmentos compartidos
   (header, footer, opciones del formulario, tarjetas de la portada).
3. `portada.py` — arma `index.html` y `admision.html` con esos fragmentos.

Para las imágenes: `imagenes.py`, con el pipeline `sips` (decodifica, incluido RAW) → `ffmpeg`
(aplica rotación EXIF, recorta *cover* y borra metadatos).

**Los slugs de `FIJOS` en `datos.py` no se pueden cambiar**: las fotos se llaman igual que ellos.

## Pendientes / notas

- **El formulario NO envía datos a ningún backend.** En el submit solo se oculta y muestra el
  mensaje de éxito (`#formOk`). Ver comentario `// Aquí luego puedes enviar los datos a tu servidor / correo.`
- **Falta la plana docente.** El bloque está comentado en las 39 páginas (`.docentes` ya tiene
  estilos). El Word con los docentes está en un Drive que aún no se ha descargado:
  `https://drive.google.com/drive/folders/1mvOI3K0wUhYwSu-5HqHhyI9AknZGG6t-`
- **18 de los 39 programas no tienen fotos**: Ing. Metalúrgica, los 7 de Educación y los 10 del
  Área V. Su banner usa el degradado verde institucional y en el HTML hay un comentario
  `FALTA FOTO` con la línea lista para descomentar; tampoco tienen galería.
- **Las fotos de Administración de Empresas y Administración Hotelera parecen intercambiadas en
  origen**: la carpeta `administracion-empresas/` contiene un bar y un laboratorio de alimentos y
  bebidas (que es el laboratorio de Hotelería según el documento), y `administracion-hotelara/`
  tiene fotos genéricas de campus. Se respetó la organización de las carpetas.
- Las 3 carreras de Química comparten una sola carpeta de fotos (`ingenria-quimica/`), con una
  foto cada una y sin galería.
- Los iconos (emoji) de las tarjetas de programa y de la ficha lateral se eliminaron a pedido del
  cliente. Los de `.lab` (laboratorios) y `.beneficio` siguen ahí.
- Sin página índice de los 39 programas: el listado completo vive en el submenú y en la portada.

## Material de referencia (NO publicar)

Archivos internos, ignorados por git (`.docx`, `.pdf` en `.gitignore`):
- `INFORMACIÓN PARA PÁGINMA WEB.docx`
- `PLAN DE ESTUDIOS 2.docx`
- `Wireframe_Admision_UNCP.pdf`
- `CORRECCIONES PÁGINA WEB UNCP.pdf`

## Git

- Rama principal: `main`.
- `.claude/`, `*.docx`, `*.pdf` y `.DS_Store` están en `.gitignore`.
