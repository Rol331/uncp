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
prospecto.html      — Prospecto de admisión   ┐ MAQUETAS: sin backend, ver Pendientes
resultados.html     — Resultados de admisión  ┘ (las 2 salen de #accesos de la portada)
inscripcion.html    — Inscripción en línea    · explica el trámite y manda al sistema oficial
                                                (ya no tiene formulario, ver Pendientes)
posgrado.html            — Posgrado 2026-II ┐ maestrías y doctorados (25/08/2026); salen del
posgrado-cronograma.html — Cronograma       │ menú «Posgrado» del header, no de #accesos
posgrado-costos.html     — Costos           ┘
qr.html             — un QR por programa, para imprimir (26/08/2026). NO está enlazada en
                      el sitio a propósito: es herramienta interna, se llega por la URL
estilos.css         — CSS de TODAS las páginas
scripts.js          — JS compartido (header, menú móvil, submenú, .revelar, contador, visor de galería)
carreras/*.html     — 39 páginas de programa (una por programa de estudio)
imagenes/           — fotos optimizadas y versionadas
  portada/slide-N.jpg      1600x900  carrusel de la portada (3)
  banner/<slug>.jpg        1600x900  banner de cada programa (los 39)
  tarjetas/<slug>.jpg       600x400  tarjetas de #carreras en la portada (las 39)
  galeria/<slug>-N.jpg      800x600  galería de cada programa (114, en 37 programas)
  qr/<slug>.svg             ~2 KB    código QR de cada programa (los 39), vectorial
img-carreras/       — ORIGINALES sin optimizar, en .gitignore (~505 MB)
```

- `index.html` carga `estilos.css` + `scripts.js` y además tiene un `<script>` en línea solo
  para lo suyo (carrusel del banner y submit del formulario).
- Las páginas de `carreras/` y `admision.html` usan las mismas hojas compartidas.
- El header, el submenú y el footer están **duplicados en las 47 páginas**: no se editan a mano,
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

## Los dos submenús del header

El menú tiene **7 entradas**: Inicio · Carreras ▾ · Admisión 2026-II · **Posgrado ▾** · Por qué
UNCP · Contacto · *Inscríbete aquí*. Las dos con ▾ son `<button class="enlace-sub">` dentro de un
`.tiene-sub`. `scripts.js` recorre **todos** los `.tiene-sub`, así que no hubo que tocar el JS al
agregar el segundo (25/08/2026, con `_pipeline/menu_posgrado.py`).

**Carreras — mega menú** (`.submenu`, 5 columnas, una por área):

- **Escritorio:** se abre al pasar el mouse (`:hover`) o al hacer clic. El panel es
  `position:fixed` centrado en el viewport (`top:92px`, `66px` con `.scrolled`), así nunca se
  desborda. Un `::after` invisible en `.tiene-sub` hace de puente para que no se cierre al bajar
  el mouse. A ≤1320px pasa a 3 columnas y a ≤1100px a 2.
- Los programas de filial llevan `class="filial" data-filial="Filial Tarma|Satipo"`; el rótulo
  lo pinta el `::after` con `content:attr(data-filial)`.

**Posgrado — submenú compacto** (`.submenu.compacto`): son 3 enlaces, no 39, así que en vez del
panel fijo cae `position:absolute` anclado bajo su botón. Gana a `header.scrolled .submenu` por
especificidad (4 clases contra 2), por eso no se reposiciona al hacer scroll.

**Móvil (≤992px):** los dos paneles pasan a `position:static` y funcionan como acordeón
(`max-height` 0 → 60vh) dentro del menú lateral. Sirve para cualquier `.submenu` que tenga un
`.submenu-area` dentro, sin reglas aparte.

**Ojo con el punto de quiebre:** la hamburguesa aparecía a ≤768px, pero con 7 entradas el menú se
partía en dos líneas entre 768 y 992px, así que **se subió a ≤992px** (993–1180px es la banda que
aprieta tipografía y paddings; ahí también entran los `.enlace-sub`, que no son `<a>`).

## Estructura de una página de programa (`carreras/*.html`)

1. **Banner** (`.banner-interior`, `#inicio`) — miga de pan, etiqueta de área, `h1`, bajada, chips
   con Título/Grado y dos botones: *Cómo postular* → `inscripcion.html#pasos` y
   *Solicitar información* → `index.html#inicio` (el formulario de la portada). La foto va en
   `background-image` de `.banner-interior-bg`, sobre ella cae el velo verde de
   `.banner-interior::before`.
2. **Información** (`#info`) — `.carrera-layout` (contenido + `aside.ficha` sticky) con cinco
   bloques: **Perfil del Egresado**, **Campo Ocupacional** (`.lista-check`), **Plan de estudios**
   (`.plan`, acordeón `<details>` por semestre), **Laboratorios** (`.labs`) y **Galería**
   (`.galeria`, 16:9, se amplía al hacer clic con el visor de `scripts.js`).
   Además queda un bloque de **plana docente** comentado, listo para llenar.
   La `aside.ficha` cierra con el botón *Inscríbete en línea*, que **sí sale al sistema oficial**
   (`erpadmision.uncp.edu.pe/inscripcion`), y su `.nota` explicándolo.
3. **Otros programas del área** (`#otras`).
4. **CTA Admisión** (`#admision`) + footer + botón de WhatsApp + visor de galería.

Los 39 programas salen de `INFORMACIÓN PARA PÁGINMA WEB.docx` y los planes de
`PLAN DE ESTUDIOS 2.docx`:
Área I Ciencias de la Salud (2) · Área II Arquitectura e Ingenierías (10) ·
Área III Ciencias Administrativas, Contables y Económicas (5, dos en Filial Tarma) ·
Área IV Ciencias Sociales y Educación (12) · Área V Ciencias Agrarias (10, una en Filial Tarma
y cuatro en Filial Satipo).

## Enlaces externos que usa el sitio

- **Casi todo el sitio navega hacia adentro** (unificado el 12/08/2026 con
  `_pipeline/unificar.py`):
  - *Inscríbete aquí* / *Postula ahora* → `inscripcion.html` (203 enlaces)
  - *Resultados* del footer → `resultados.html` (41)
  - *Ver el prospecto* (antes decía *Descargar prospecto*) y *Prospecto* → `prospecto.html` (83)
- **Tres salidas que quedan a propósito:**
  - El botón *Descargar el prospecto (PDF)* de `prospecto.html`, que va al Drive
    `1tqgMdpMqXMnMaxNtdWzaMPL4I5DOa6M0`. Es el documento en sí, no una pantalla ajena, y si se
    quita se pierde la descarga real del prospecto.
  - *Inscríbete en línea* de la `aside.ficha` de las 39 páginas de programa y
    *Inscríbete en el sistema* del banner de `inscripcion.html`, los dos a
    `erpadmision.uncp.edu.pe/inscripcion` (pedido del cliente el 14/08/2026, así el postulante
    sí puede inscribirse de verdad). `unificar.py` los reconoce por la etiqueta y ya no los toca:
    están en su lista `PROTEGIDOS`, **no la vacíes** o al volver a correrlo se pierden.
- **Los 4 documentos de posgrado** (25/08/2026), en `posgrado.html` y en el CTA de sus dos
  subpáginas. Son el documento en sí, igual que el prospecto de pregrado, así que salen a Drive:
  prospecto `1CazEJW7UAE7crV3TvLICqckq4QVcHqyS` · doctorados `1d_oUhzM6WzdPWfXQwDvljPC_xmyS5s40` ·
  maestrías `1DHG-EeGuouNROZ2eP2O6fUyaoA7GfYwi` · vacantes `1BM3PPinlHoEFJo5JTMcJmHHHEqIHul6A`.
  `unificar.py` no los toca: solo conoce el id del prospecto de pregrado.
- **El sistema de inscripción de posgrado**, `uncpadmision.edu.pe/posgrado/registration/login.php`.
  **No es el de pregrado** (`erpadmision.uncp.edu.pe/inscripcion`): son dos sistemas distintos.
  Está en dos sitios, los dos pedidos por el cliente el 26/08/2026: el botón flotante dorado
  *Inscripción Posgrado* de la portada (abajo a la izquierda, espejo del de WhatsApp, **solo en
  `index.html`**) y el botón *Inscríbete en línea* del banner de `posgrado.html`. En el generador
  es la constante `SISTEMA_POSGRADO`.
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

`imagenes.py` se perdió; está rehecho en `img-carreras/_pipeline/` (fuera del repo, junto a los
originales): `fotos.py` (`listar` / `hojas` / `generar` + el mapeo carpeta→slug de los 39
programas), `seleccion.json` (qué foto es el banner y cuáles la galería de cada programa),
`marcado.py` (mete banner, galería y tarjetas en el HTML) y `NOTAS.md`.

`paginas_extra.py` (mismo directorio) rehace **seis** páginas: `prospecto.html`,
`inscripcion.html`, `resultados.html`, `posgrado.html`, `posgrado-cronograma.html` y
`posgrado-costos.html`. Les copia la cabecera y el pie de `admision.html`, así el header, el
submenú y el footer salen idénticos al resto del sitio. **Esas seis páginas no se editan a mano**,
se regeneran con ese script. Detalles suyos:
- `docs_grid()` arma las tarjetas `.doc`; si el destino es `None` sale un `<div class="doc
  doc-inactivo">` sin enlace, para los documentos que el cliente aún no entregó.
- `pie_con_cta()` cambia el CTA del pie en las páginas de posgrado: el de `admision.html` habla de
  pregrado (manda a `inscripcion.html` y a los 39 programas) y ahí engañaría al postulante.
- `banner(..., padre=("Posgrado","posgrado.html"))` mete el eslabón intermedio en la miga de pan.
- Los pasos y las tarjetas se arman **dentro de f-strings**, y ahí Python no admite comentarios
  (`SyntaxError: f-string expression part cannot include '#'`): van arriba de la función.
- Su `opciones_programas()` (el `<select>` de los 39 programas sacado de `index.html`) quedó sin
  uso al borrarse la ficha de inscripción, pero se conserva para cuando el sistema se conecte.

Otros cuatro del mismo directorio, para cambios que van en varias páginas a la vez (los cuatro
traen simulación: sin `--escribir` solo informan):
- `unificar.py` — manda a las páginas locales los enlaces que salían al sistema oficial, **salvo
  los de su lista `PROTEGIDOS`** (ver *Enlaces externos*).
- `redes.py` — pone los logos SVG de Facebook, Instagram, YouTube y TikTok en el footer.
- `botones.py` — los tres botones de acción de las 39 páginas de `carreras/` (*Cómo postular*,
  *Solicitar información* del banner e *Inscríbete en línea* de la ficha). Es idempotente: busca
  el texto viejo, así que una segunda corrida no encuentra nada y no rompe nada.
- `menu_posgrado.py` — cuelga la entrada *Posgrado ▾* del header a la derecha de *Admisión
  2026-II*, en las 47 páginas (las de `carreras/` con `../`). Idempotente: se salta la página si
  ya encuentra `id="submenuPosgrado"`. **Correr antes que `paginas_extra.py`**, que copia la
  cabecera de `admision.html`.

`qr.py` (mismo directorio) hace los 39 `imagenes/qr/<slug>.svg` y `qr.html`. Los programas los lee
del submenú de `admision.html`, así no hay una segunda lista que mantener, e importa los helpers de
`paginas_extra.py` para que la página salga con la cabecera y el pie del sitio.

- Es el único script que necesita algo de fuera: **`segno`** (Python puro), en un venv del mismo
  directorio (fuera del repo): `python3 -m venv venv && ./venv/bin/pip install segno`.
  Se corre con `./venv/bin/python qr.py --escribir`.
- **El dominio va cableado en `BASE`** (`https://uncpadmision.edu.pe/`, el de producción, que
  confirmó el cliente el 26/08/2026 — y ahí las 39 URLs responden 200). Un QR impreso no se
  corrige: si el sitio se publica en otra dirección hay que regenerarlos **antes** de mandar a
  imprenta, con `--base https://otra-direccion/`.
- Los QR llevan `error="q"` (25% de recuperación, aguanta tinta corrida y dobleces) y van en
  `#00301C`, no en negro. Van de la versión 5 a la 8 según el largo del slug.
- Los estilos `.qr-*` y la hoja de impresión están en `estilos.css`, y las reglas de `@media print`
  cuelgan de `body class="pagina-qr"`, que se la pone el propio script. Esa hoja **fuerza
  `.revelar{opacity:1}`**: si no, al imprimir el título sale en blanco porque el JS de las
  animaciones no corre.

**Los slugs de `FIJOS` en `datos.py` no se pueden cambiar**: las fotos se llaman igual que ellos.

## Pendientes / notas

- **El formulario NO envía datos a ningún backend.** En el submit solo se oculta y muestra el
  mensaje de éxito (`#formOk`). Ver comentario `// Aquí luego puedes enviar los datos a tu servidor / correo.`
- **`prospecto.html` y `resultados.html` son solo maquetación** (hechas el 12/08/2026 para que las
  tarjetas de `#accesos` no manden al sitio oficial). No tienen backend:
  - Los `<input>`, `<select>` y botones van con `disabled` y el `<form>` con `onsubmit="return false"`.
  - Las dos llevan arriba una franja `.maqueta` diciéndolo. **No la quites** mientras siga sin
    conexión, y no le saques el `disabled` a los campos: harían creer que se envía algo.
  - La tabla de `resultados.html` **no tiene datos reales**: son guiones y textos de molde a
    propósito, para que nadie los confunda con resultados oficiales.
  - `prospecto.html` **sí entrega el PDF** con su botón del banner; su maqueta es el resto
    (capítulos y formas de obtenerlo).
  - **Falta conectar la consulta por DNI de `resultados.html`** al sistema de la Universidad.
- **`inscripcion.html` ya no es maqueta** (14/08/2026). El cliente marcó *NO VA* sobre la ficha de
  inscripción, así que se borró el formulario entero; sin formulario falso no hay nada que
  advertir y la página tampoco lleva la franja `.maqueta`. Queda como página explicativa —los
  cuatro pasos y los documentos— y su botón del banner (*Inscríbete en el sistema*) manda al
  sistema oficial, igual que el de la ficha de las 39 páginas de programa. Así el postulante sí
  puede inscribirse de verdad. Los textos de los cuatro pasos y de los requisitos son los que
  dictó el cliente en `1 CORRECCIÓN.docx`: **los requisitos ya no son para inscribirse, son los
  documentos que se piden si ingresas**.
- **Posgrado: faltan 3 enlaces y 1 fecha** (páginas hechas el 25/08/2026 con el diseño que pasó el
  cliente). Las tarjetas están puestas pero **apagadas y sin `<a>`** (`.doc.doc-inactivo`, dicen
  *Disponible próximamente*), así que basta pegar la URL en `paginas_extra.py` y regenerar:
  - *Perfil del proyecto de investigación* (sección Información adicional).
  - *Doctorados* y *Maestrías* de la sección Resultados.
  - En el cronograma, la **publicación de resultados dice «Fecha por confirmar»**: la captura del
    cliente ponía *martes 25 de marzo de 2026*, entre inscripciones de julio-agosto y constancias
    del 28 de agosto, así que parece errata. Confirmar con él (¿25 de agosto?).
  - El menú y el footer de esas páginas son los compartidos, o sea que su *Inscríbete aquí* y sus
    enlaces siguen siendo de **pregrado**. Si el cliente quiere que posgrado tenga los suyos, hay
    que separarlos.
- **Falta la plana docente.** El bloque está comentado en las 39 páginas (`.docentes` ya tiene
  estilos). El Word con los docentes está en un Drive que aún no se ha descargado:
  `https://drive.google.com/drive/folders/1mvOI3K0wUhYwSu-5HqHhyI9AknZGG6t-`
- **Los 39 programas ya tienen banner y tarjeta.** Sin galería quedan dos, porque de cada uno hay
  una sola foto; en sus páginas hay un comentario `SIN GALERIA` explicándolo:
  - **Agronomía Tropical** — del RAR del cliente llegó una sola foto de ese programa.
  - **Ingeniería Ambiental** — no vino en el RAR. El cliente eligió a mano (12/08/2026) la foto
    `P2211186` de la carpeta de *Forestal y Ambiental*, así que **las dos carreras comparten esa
    foto**: es el banner de Ambiental y a la vez `galeria-4` de Forestal y Ambiental.
- **Dos líneas de `.galeria` que no se pueden quitar** (las dos corregidas el 12/08/2026, las dos
  llevan comentario en `estilos.css`):
  - `height:auto` en `.galeria img` — sin eso el atributo HTML `height="600"` del `<img>` pisa al
    `aspect-ratio:16/9` y la galería se dibuja vertical (344x600) recortando los lados.
  - `pointer-events:none` en `.galeria figure::after` y `::before` — el velo `inset:0` cubre la
    foto y, aunque tenga `opacity:0`, **se come el clic**: aterriza en el `<figure>` y el visor de
    `scripts.js` (que escucha en `.galeria img`) no abría nunca.
- **Las fotos de Administración de Empresas y Administración Hotelera parecen intercambiadas en
  origen**: la carpeta `administracion-empresas/` contiene un bar y un laboratorio de alimentos y
  bebidas (que es el laboratorio de Hotelería según el documento), y `administracion-hotelara/`
  tiene fotos genéricas de campus. Se respetó la organización de las carpetas.
- Las 3 carreras de Química ya tienen fotos propias: en la entrega del cliente vinieron en
  carpetas separadas, así que se les rehizo el banner y se les dio galería (antes compartían la
  carpeta `ingenria-quimica/` con una foto cada una).
- Los iconos (emoji) de las tarjetas de programa y de la ficha lateral se eliminaron a pedido del
  cliente. Los de `.lab` (laboratorios) y `.beneficio` siguen ahí.
- Las redes del footer llevan el **logo de cada marca en SVG** (antes eran las letras «f», «ig»,
  «yt», «tk»). Van en línea, con `fill:currentColor`, así heredan el color del círculo y el hover
  dorado funciona sin reglas aparte. Se ponen con `_pipeline/redes.py`.
- Sin página índice de los 39 programas: el listado completo vive en el submenú y en la portada.

## Material de referencia (NO publicar)

Archivos internos, ignorados por git (`.docx`, `.pdf` en `.gitignore`):
- `INFORMACIÓN PARA PÁGINMA WEB.docx`
- `PLAN DE ESTUDIOS 2.docx`
- `Wireframe_Admision_UNCP.pdf`
- `CORRECCIONES PÁGINA WEB UNCP.pdf`
- `1 CORRECCIÓN.docx` y `2 CORRECCIONES.pdf` — la ronda del 14/08/2026: la primera son capturas de
  `inscripcion.html` con los textos nuevos encima y el *NO VA* sobre la ficha; la segunda, los tres
  botones de las páginas de programa. Las dos son imágenes anotadas, no texto: para leerlas hay que
  convertirlas con LibreOffice (`soffice --headless --convert-to pdf`) y mirar las páginas.

## Git y publicación

- Rama principal: `main`. Repo: `https://github.com/Rol331/uncp.git`.
- `.claude/`, `*.docx`, `*.pdf`, `.DS_Store` y el candado de LibreOffice están en `.gitignore`.
- **Dos direcciones** (comprobado el 26/08/2026):
  - `https://rol331.github.io/uncp/` — GitHub Pages, sale de `main` en cada push. Es donde se
    revisa el trabajo.
  - `https://uncpadmision.edu.pe/` — **producción**, la que ve el postulante y a la que apuntan
    los QR. **No se actualiza sola:** ese día tenía el despliegue anterior (las 39 páginas de
    programa e `inscripcion.html` sí, pero `posgrado.html` daba 404). Copiar los archivos ahí es
    un paso aparte, fuera de este repo.
