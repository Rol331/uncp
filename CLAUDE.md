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
estilos.css         — CSS de TODAS las páginas (variables, header, submenú, banner, carrera)
scripts.js          — JS compartido (header scroll, menú móvil, submenú, .revelar, contador)
carreras/*.html     — 22 páginas de carrera (una por carrera)
```

- `index.html` carga `estilos.css` + `scripts.js` y además tiene un `<script>` en línea solo para lo suyo (carrusel del banner y submit del formulario).
- Las páginas de `carreras/` usan `../estilos.css` y `../scripts.js`.
- Al cambiar el header o el submenú hay que tocarlo en `index.html` **y** en las 22 páginas de carrera (el markup está duplicado; se generó con un script).

## Diseño

- Color principal (verde institucional): `#00301C`. Acento dorado: `#c9a24b`.
- Variables CSS en `:root` (`--verde-900`, `--dorado`, `--crema`, radios, sombras, transiciones).
- Tipografía del sistema (Segoe UI / system-ui).
- Responsive con `clamp()`, grid y menú hamburguesa móvil.

## Estructura de `index.html`

- **Header fijo** (`#header`) — cambia de estilo al hacer scroll (clase `.scrolled`).
- **Banner** (`#inicio`) — carrusel automático (6s) + formulario de captación (`#formInfo`: nombre, correo, teléfono, interés con las 22 carreras en `optgroup` por área).
- **Stats** — contadores animados con `IntersectionObserver`.
- **Carreras** (`#carreras`) — 6 tarjetas destacadas (Ing. de Sistemas, Medicina Humana, Administración de Empresas, Derecho, Arquitectura, Enfermería), cada una enlaza a su página.
- **Por qué elegirnos** (`#porque`).
- **CTA Admisión** (`#admision`).
- **Footer** (`#contacto`).

## Submenú de carreras (mega menú)

En el header, "Carreras" es un `<button class="enlace-sub">` dentro de `.tiene-sub`, con el panel `.submenu` (4 columnas, una por área).

- **Escritorio:** se abre al pasar el mouse (`:hover`) o al hacer clic. El panel es `position:fixed` centrado en el viewport (`top:82px`, `66px` con `.scrolled`), así nunca se desborda. Un `::after` invisible en `.tiene-sub` hace de puente para que no se cierre al bajar el mouse.
- **Móvil (≤768px):** el panel pasa a `position:static` y funciona como acordeón (`max-height` 0 → 60vh) dentro del menú lateral.

## Estructura de una página de carrera (`carreras/*.html`)

1. **Banner** (`.banner-interior`, `#inicio`) — miga de pan, etiqueta de área, `h1`, bajada, chips con Título/Grado y botones. La foto va en `background-image` de `.banner-interior-bg`.
2. **Información** (`#info`) — `.carrera-layout` (contenido + `aside.ficha` sticky) con tres bloques: **Perfil del Egresado**, **Campo Ocupacional** (`.lista-check`) y **Laboratorios** (`.labs`).
3. **Otras carreras del área** (`#otras`).
4. **CTA Admisión** (`#admision`) + footer.

Las 22 áreas/carreras salen de `INFORMACIÓN PARA PÁGINMA WEB.docx`:
Área I Ciencias de la Salud (2) · Área II Arquitectura e Ingenierías (10) · Área III Ciencias Administrativas, Contables y Económicas (5, dos en Filial Tarma) · Área IV Ciencias Sociales y Educación (5).

## JavaScript

- `scripts.js` (compartido): header con scroll, menú móvil, submenú (`cerrarSubmenus`, clic fuera, `Escape`, `aria-expanded`), animaciones `.revelar` → `.visible` y contador animado.
- En línea en `index.html`: carrusel del banner (`mostrar`/`irA`/`siguiente`/`anterior`) y submit del formulario.

## Pendientes / notas

- **El formulario NO envía datos a ningún backend.** En el submit solo se oculta y muestra el mensaje de éxito (`#formOk`). Ver comentario `// Aquí luego puedes enviar los datos a tu servidor / correo.`
- **Todas las imágenes son placeholders de `loremflickr.com`** (banner de portada, tarjetas de carrera y banner de cada página de carrera) — reemplazar por fotos reales. En cada `carreras/*.html` hay un comentario `REEMPLAZAR LA FOTO` justo antes del `background-image`.
- Ing. Agronómica y Educación **no figuran** en el documento oficial, por eso no tienen página.
- Sin página índice de las 22 carreras: el listado completo vive solo en el submenú.
- Enlaces aún sin destino: redes sociales del footer, Becas, Cronograma, Modalidades, Prospecto, Resultados.

## Material de referencia (NO publicar)

Archivos internos, ignorados por git (`.docx`, `.pdf` en `.gitignore`):
- `INFORMACIÓN PARA PÁGINMA WEB.docx`
- `PLAN DE ESTUDIOS 2.docx`
- `Wireframe_Admision_UNCP.pdf`

## Git

- Rama principal: `main`.
- `.claude/`, `*.docx`, `*.pdf` y `.DS_Store` están en `.gitignore`.
