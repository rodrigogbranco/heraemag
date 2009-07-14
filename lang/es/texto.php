<?php
$texto['dona_alt'] = 'Done ahora: Contribuya al desarrollo de HERA';
$texto['intro_h1'] = '¿Qué es HERA?';
$texto['intro_a'] = '<strong>HERA</strong> es una utilidad para revisar la accesibilidad de las páginas web de acuerdo con las recomendaciones de las <em>Directrices de Accesibilidad para el Contenido Web 1.0</em> (<a href="http://www.w3.org/TR/WCAG10/" title="Web Content Accessibility Guidelines 1.0" hreflang="en">WCAG 1.0</a>). <strong>HERA</strong> realiza un análisis automático previo de la página e informa si se encuentran errores <em>(detectables en forma automática)</em> y qué puntos de verificación de las pautas deben ser revisados manualmente.';
$texto['intro_b'] = 'La revisión manual es imprescindible para comprobar realmente si la página es accesible. Para poder llevar a cabo esta verificación manual es necesario conocer las directrices de accesibilidad, saber cómo utilizan los usuarios las ayudas técnicas y tener alguna experiencia en diseño y desarrollo de páginas web.';
$texto['intro_c'] = '<strong>HERA</strong> facilita la revisión manual proporcionando información acerca de los elementos a verificar, instrucciones sobre cómo realizar ese control y dos vistas modificadas de la página <em>(una en modo gráfico, otra del código HTML)</em> con los elementos más importantes destacados con iconos y colores distintivos.';
$texto['intro_d'] = 'Un formulario permite modificar los resultados automáticos, agregar comentarios a cada punto de verificación e indicar el nombre del revisor. También es posible generar un informe final sobre la revisión, para imprimir o descargar, en diversos formatos (<acronym title="Extensible HyperText Markup Language" lang="en">XHTML</acronym>, <acronym title="Resource Description Framework" lang="en">RDF</acronym> y <acronym title="Portable Document Format" lang="en">PDF</acronym>).';
$texto['intro_e'] = '<strong>Importante: </strong> Los datos se conservarán en la base de datos de <strong>Sidar</strong> por el término de 7 (siete) días a partir del inicio de la revisión. Durante ese lapso es posible retomar un trabajo utilizando la URL de la página resumen, que contiene el identificador de la revisión.';
$texto['help_h1'] = 'Ayuda de HERA';
$texto['help_a'] = 'Una vez indicada la página a revisar, <strong>HERA</strong> muestra un resumen con la información obtenida en el análisis automático y define un resultado para cada punto de control.';
$texto['help_img_1'] = 'Vista del resumen de resultados.';
$texto['help_dd_bien'] = 'Cuando el análisis puede detectar, sin lugar a dudas, que la página cumple con los requisitos de accesibilidad de ese punto.';
$texto['help_dd_duda'] = 'Cuando el análisis no puede confirmar, con toda certeza, el cumplimiento del punto y se requiere la interpretación del usuario. En este caso, <strong>HERA</strong> proporciona opciones para efectuar la <a href="#op">revisión manual</a>.';
$texto['help_dd_mal'] = 'Cuando el análisis puede detectar que la página no cumple, parcial o totalmente, con los requisitos de accesibilidad.';
$texto['help_dd_na'] = 'Cuando el punto hace referencia a elementos que no se encuentran presentes en la página.';
$texto['help_dd_parcial'] = 'Cuando el cumplimiento de los requisitos de accesibilidad no es completo.';
$texto['help_dd_nose'] = 'Cuando el revisor no puede confirmar si el punto de control se cumple o no.';
$texto['help_b'] = 'En esta etapa existe siempre una cierta cantidad de puntos a verificar por el usuario. Una vez que la persona a comprobado un punto, puede utilizar el formulario para modificar su resultado. El formulario ofrece otros dos posibles resultados, que se suman a los anteriores.';
$texto['help_img_2'] = 'Vista del cuadro de resumen de resultados incluyendo revisiones hechas por el usuario.';
$texto['help_h2_a'] = 'Revisión manual';
$texto['help_h2_b'] = 'Barra de íconos';
$texto['help_c'] = 'Cada punto puede abarcar uno o varios ítems a revisar, cada uno de los cuales tendrá su propio resultado. Si los resultados de los ítems no coinciden entre sí, el resultado general del punto se decide por el ítem con el peor resultado. Por ejemplo: si uno de los ítems es "incorrecto", el resultado del punto también lo será, cualesquieran sean los resultados de los demás ítems del punto.';
$texto['help_img_3'] = 'Vista del formulario de revisión de un punto.';
$texto['help_d'] = '<strong>HERA</strong> ofrece varias opciones para ayudar al revisor a verificar cada ítem. Cuando resulta posible, se indican los elementos encontrados en la página y qué se debe revisar. A continuación de este texto, se ubican tres íconos para las ayudas.';
$texto['help_icon_a'] = 'Muestra/oculta las instrucciones necesarias para hacer la revisión.';
$texto['help_icon_b'] = 'Muestra en ventana aparte la página, con los elementos a revisar destacados mediante íconos, recuadros de color y, generalmente, muestra el código de cada elemento. Como estos agregados a la página original se pueden superponer a otros elementos, existe una opción para activar y desactivar las hojas de estilo de la página.';
$texto['help_icon_c'] = 'Muestra en ventana aparte el código de la página, con los elementos a revisar destacados mediante íconos y recuadros de color.';
$texto['help_icon_d'] = 'Abre la página en una nueva ventana.';
$texto['help_icon_e'] = 'Abre una nueva ventana para mostrar el código original de la página.';
$texto['help_icon_f'] = 'Devuelve a la página resumen, desde la cual es posible elegir el modo de navegar por los puntos de verificación.';
$texto['help_icon_g'] = 'Muestra/oculta los textos de ayuda para cada uno de los puntos de verificación.';
$texto['help_icon_h'] = 'Muestra/oculta el formulario para modificar los resultados de cada punto.';
$texto['help_icon_i'] = 'Lleva al formulario para solicitar el informe de la revisión. Este informe se puede obtener en diversos formatos (XHTML, RDF y PDF).';
$texto['help_e'] = 'De este modo, utilizando ambas vistas de la página como ayuda, el revisor podrá identificar los elementos importantes, valorar su uso y decidir el resultado para cada ítem del punto.';
$texto['help_f'] = 'Dos iconos, ubicados junto a la URL de la página en revisión, permiten abrir la página original y ver su código, en ambos casos sin ninguno de los agregados que efectúan las opciones anteriores.';
$texto['help_h3_estil'] = 'Estilos de trabajo';
$texto['help_estil_a'] = 'La revisión completa puede hacerse navegando por la tabla de resultados o siguiendo la numeración de las directrices.';
$texto['help_h41_estil'] = 'Navegar por directrices';
$texto['help_img_4'] = 'Detalle del acceso a la navegación por directrices.';
$texto['help_estil_b'] = 'Desde la página Resumen se accede a la navegación por directrices, que se presentan mediante botones al final de la misma. Una vez se ha elegido esta opción, aparecerán los puntos de control, de la directriz seleccionada, para ser revisados. Para facilitar la navegación por directrices, aparecen en la parte superior de la página de revisión los botones con el número de cada una de ellas.';
$texto['help_h42_estil'] = 'Navegar por resultados';
$texto['help_img_5'] = 'Detalle del acceso a la navegación por resultados.';
$texto['help_estil_c'] = 'A la navegación por resultados se accede desde la tabla resumen de los mismos. Esta forma de navegación puede hacer más animada la tarea pues se va viendo claramente los puntos que se van resolviendo, especialmente cuando el revisor trabaja sobre su propio sitio y puede arreglar los fallos encontrados. En la parte superior de la página de revisión aparece la tabla que va mostrando los resultados con las modificaciones indicadas por el revisor.';
$texto['help_h3_informe'] = 'Generar el informe';
$texto['help_informe_a'] = 'Al pulsar sobre el icono para solicitar el informe aparecerá un formulario en el que el revisor puede indicar su nombre, dirección de correo electrónico, el título que quiera darle al informe, y un campo para introducir un comentario general.';
$texto['help_informe_b'] = 'Puede entonces seleccionarse qué tipos de resultados (A verificar, correcto, incorrecto, no aplicable, parcial, no sé) se desean incluir en el informe, o si se desea incluir todos.';
$texto['help_informe_c'] = 'Una vez hecho esto, se puede elegir el o los tipos de informes a generar, como veremos a continuación.';
$texto['help_h4_infor1'] = 'Informe <acronym title="Hypertext Markup Language" xml:lang="en" lang="en">HTML</acronym>';
$texto['help_img_6'] = 'Vista del informe en formato html.';
$texto['help_informe_d'] = 'En el formulario hay un botón para ver el informe en formato <acronym title="Hypertext Markup Language" xml:lang="en" lang="en">HTML</acronym>, que abrirá una nueva ventana del navegador con el informe en ese formato, lo que supone que puede imprimirse directamente desde allí, utilizando el botón o la opción de menú para imprimir del navegador que se esté usando.';
$texto['help_informe_e'] = 'También hay un botón especial para descargar el informe en formato html. De esta manera, pueden guardarse con el nombre que se desee, para publicarlos en la web o para publicarlos en papel. El revisor puede entonces, si lo requiere, crear una hoja de estilos especial para la impresión, de manera que se ajuste al papel membrete de su empresa y añadirla a los ficheros en formato html descargados.';
$texto['help_h4_infor2'] = 'Informe <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym>';
$texto['help_img_7'] = 'Vista de un informe en rdf presentado mediante el visualizador de informes.';
$texto['help_informe_f'] = 'HERA genera también el informe en formato <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym>, contribuyendo así a que tengamos y aprovechemos las posibilidades de una web semánticamente más rica.';
$texto['help_informe_g'] = 'El botón &#x22;Ver el informe <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym>&#x22; abrirá una nueva ventana del navegador con el contenido del informe en lenguaje EARL y en formato RDF. Es posible que algún usuario no pueda ver directamente en su navegador este informe si su utiliza una aplicación antigua incapaz de soportar XML, pero no hay que preocuparse, pues estos informes no están pensados para ser leídos por los humanos sino por las máquinas. De todas maneras, puede utilizarse, si se desea, el <a title="Ejemplos de aplicación y descarga del script de visualización de informes." href="http://www.sidar.org/informes/">script de visualización de informes</a>, y podrán publicarse en su propia web, de manera que sean legibles y atractivos para los usuarios humanos y acordes con el aspecto general de su propio sitio web.';
$texto['help_informe_h'] = 'El botón &#x22;Descargar el informe <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym>&#x22; permite, como su nombre indica, descargar el fichero con el informe generado, para guardarlo y publicarlo donde y como se desee. El revisor o equipo de revisión puede optar por usar el script antes mencionado, o publicar directamente los ficheros <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym> enlazados desde cada una de las páginas que han sido revisadas. Incluso podrá generar un gráfico de la revisión, valiéndose del <a href="http://www.w3.org/RDF/Validator/" hreflang="en">revisor de sintaxis <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym></a>, del W3C.';
$texto['help_h4_infor3'] = 'Informe en <acronym title="Portable Document Format" xml:lang="en" lang="en">PDF</acronym>';
$texto['help_img_8'] = 'Vista de un informe en formato PDF.';
$texto['help_informe_i'] = 'Una opción más, consiste en generar el informe en formato <acronym title="Portable Document Format" xml:lang="en" lang="en">PDF</acronym>. Se trata de una versión <em>en bruto</em>, de manera que el usuario de HERA pueda descargarlo y hacer las marcas, estructuración, y modificaciones oportunas para publicarlo en ese formato con el diseño de maquetación que prefiera. (Por favor, no olvide estructurar el documento antes de publicarlo, para que sea lo más accesible posible).';
$texto['help_h3_declara'] = 'Declarar haber hecho la revisión con HERA';
$texto['help_declara_a'] = 'Una vez hecha la revisión y, en su caso, las modificaciones oportunas para alcanzar el nivel de accesibilidad deseado, conviene declararlo; y para ello usar uno de los siguientes iconos enlazados, idealmente, con el informe en formato <acronym title="Resource Description Framework" xml:lang="en" lang="en">RDF</acronym> generado por HERA, de esta manera los robots serán capaces de indexar su página entre las que cumplen con determinadas características de accesibilidad o, en otro caso, con la <a href="http://www.w3.org/WAI/WCAG1AA-Conformance">página de conformidad con las Directrices de Accesibilidad para el Contenido Web 1.0 del <acronym title="Web Accessibility Initiative" xml:lang="en" lang="en">WAI</acronym></a>.';
$texto['help_declara_b'] = 'Puede elegir uno los siguientes iconos de estilo &#x22;clásico&#x22; de acuerdo con el nivel alcanzado:';
$texto['help_declara_c'] = 'O elegir el icono apropiado de estilo más actúal:';
$texto['help_declara_d'] = 'O crear uno de los siguientes botones utilizando únicamente Hojas de Estilo en Cascada:';
$texto['help_declara_e'] = '<ul class="navlistpie">
<li class="botonhera"><a href="http://www.sidar.org/hera/" title="HERA: Revisando con Estilo la Accesibilidad."><span class="hera">HERA</span> <span class="spec"><acronym title="Web Accessibility Initiative" lang="en">WAI</acronym>-<acronym title="Conforme con el nivel A de Accesibilidad" style="background: transparent; color: Maroon;">A</acronym></span></a></li>
<li class="botonhera"><a href="http://www.sidar.org/hera/" title="HERA: Revisando con Estilo la Accesibilidad."><span class="hera">HERA</span> <span class="spec"><acronym title="Web Accessibility Initiative" lang="en">WAI</acronym>-<acronym title="Conforme con el nivel Doble A de Accesibilidad" style="background: transparent; color: Maroon;">AA</acronym></span>  </a></li>
<li class="botonhera"><a href="http://www.sidar.org/hera/" title="HERA: Revisando con Estilo la Accesibilidad."><span class="hera">HERA</span> <span class="spec"><acronym title="Web Accessibility Initiative" lang="en">WAI</acronym>-<acronym title="Conforme con el nivel Triple A de Accesibilidad" style="background: transparent; color: Maroon;">AAA</acronym></span></a></li>
</ul>';
$texto['help_declara_f'] = 'Los estilos usados en esos botones están definidos en <a title="Descarga la hoja de estilos que define los botones de HERA." href="botonhera.css">botonhera.css</a>.';
$texto['help_h3_integra'] = 'Integrar HERA en su navegador';
$texto['help_integra_a'] = 'Los desarrolladores y consultores encontrarán útil provocar la ejecución de HERA directamente desde un botón en su navegador. Para ello ofrecemos aquí varias opciones:';
$texto['help_h4_integra1'] = 'Favelets';
$texto['help_integra_b'] = 'Los <span xml:lang="en" lang="en">Favelets</span> o <span xml:lang="en" lang="en">Bookmarklets</span> son pequeños fragmentos de <span xml:lang="en" lang="en">JavaScripts</span> incrustados en un enlace y que permiten añadir su funcionalidad al listado de favoritos del navegador.';
$texto['help_integra_c'] = 'Para su funcionamiento requieren del soporte de <span xml:lang="en" lang="en">JavaScript</span> en el navegador. La mayoría de los Favelet funcionan bien en Internet Explorer 5.0 o superior y  en los navegadores de la familia Mozilla 1.0 o superior (Incluidos Netscape y Firefox).';
$texto['help_integra_d'] = 'Estos que aquí presentamos han sido probados en Internet Explorer 6.0, Mozilla 1.7.7, Mozilla 1.8a6, Netscape 7.2, Firefox 1.0.4, Opera 7.50 y Opera 8.0.';
$texto['help_integra_e'] = 'Para tener un acceso directo a <strong>HERA</strong> desde su navegador, bastará con que arrastre uno o varios de los siguientes enlaces a la barra de favoritos del mismo. Se creará un botón o acceso directo. Entonces, cada vez que desee usarlo bastará con que pulse o seleccione el botón que desee utilizar.';
$texto['help_integra_f'] = '<dl>
<dt><a href="javascript:void(window.location=\'http://www.sidar.org/hera/?url= \'+escape(window.location))"><img src="img/genhera.gif" alt="" width="16" height="16" style="border: none; padding-right: 1em;" />HERA: Revisa página actual</a></dt>
<dd>Llama a HERA para que revise la página que tiene el foco activo en el navegador y lo hace en la misma ventana.</dd>
<dt><a href="javascript:void(window.open(\'http://www.sidar.org/hera/?url=\'+escape(window.location),\'_blank\'));"><img src="img/genhera.gif" alt="" width="16" height="16" style="border: none; padding-right: 1em;" />HERA: Revisa página actual en nueva ventana</a></dt>
<dd>Llama a HERA para revisar la página que se está visitando, y que la revisión la haga en una ventana nueva.</dd>
<dt><a href="javascript:void(q=prompt(\'Validate Page:\',\'\'));if(q)void(window.location=\'http://www.sidar.org/hera/?url=\'+escape(q))"><img src="img/genhera.gif" alt="" width="16" height="16" style="border: none; padding-right: 1em;" />Revisar con HERA</a></dt>
<dd>Abre un cuadro de diálogo en el que se puede indicar la dirección de la página que se quiere revisar y lo hace en la ventana actualmente activa.</dd>
<dt><a href="javascript:void(q=prompt(\'Validate Page:\',\'\'));if(q)window.open(\'http://www.sidar.org/hera/?url=\'+escape(q));void%200"><img src="img/genhera.gif" alt="" width="16" height="16" style="border: none; padding-right: 1em;" />Revisar con HERA en nueva ventana</a></dt>
<dd>Abre un cuadro de diálogo para indicar la dirección de la página que se quiere revisar y abre una nueva ventana con los resultados.</dd>
</dl>';
$texto['help_integra_f1'] = 'Estos Favelets o Bookmarklets han sido creados por Emmanuelle Gutiérrez y Restrepo, con la colaboración de <span lang="fr">Vincent Tabard</span> y del equipo de <span lang="en">Opera Software</span>.';
$texto['help_h4_integra2'] = 'Añadir HERA a la &#x22;<span xml:lang="en" lang="en">Web Developer Extension</span>&#x22;';
$texto['help_integra_g'] = 'Los desarrolladores que utilizan Mozilla o Firefox suelen usar una extensión creada por  <a href="http://chrispederick.com/" hreflang="en"><span xml:lang="en" lang="en">Chris  Pederick</span></a> llamada &#x22;<a href="http://chrispederick.com/work/firefox/webdeveloper/" hreflang="en">Web Developer Extension</a>&#x22; y que añade un menú y una barra de herramientas con una serie de funcionalidades útiles para comprobar determinados aspectos de una página Web.';
$texto['help_integra_h'] = 'La extensión ofrece acceso directo a una serie de revisores y es muy sencillo agregar una opción para revisar con HERA:';
$texto['help_integra_i'] = 'Una vez que se tiene instalada la extensión, pulsando con el botón derecho del ratón sobre cualquier página abierta, seleccione &#x22;<span xml:lang="en" lang="en">Web Developer</span>&#x22; &#x3E;&#x3E; &#x22;<span xml:lang="en" lang="en">Options</span>&#x22; &#x3E;&#x3E; &#x22;<span xml:lang="en" lang="en">Options.</span>&#x22; (Si ha instalado la versión en español las opciones serán &#x22;<span lang="es">Opciones</span>&#x22; &#x3E;&#x3E; &#x22;<span lang="es">Opciones..</span>&#x22;.';
$texto['help_img_integrai'] = 'Detalle del menú contextual con las opciones del Web Developer';
$texto['help_integra_i2'] = 'En el cuadro de diálogo que se abre, seleccione &#x22;<span xml:lang="en" lang="en">Tools</span>&#x22; y pulse el botón &#x22;<span xml:lang="en" lang="en">Add</span>&#x22; (En español: &#x22;<span lang="es">Herramientas</span>&#x22; &#x3E;&#x3E; &#x22;<span lang="es">Añadir</span>&#x22;).'; 
$texto['help_img_integrai2'] = 'Detalle del cuadro de diálogo de opciones del Web Developer';
$texto['help_integra_i3'] = 'Se abrirá un cuadro de diálogo en el que se debe indicar el nombre de la herramienta (en este caso, HERA) y un campo para la URL en la que hay que poner: &#x22;http://www.sidar.org/hera/?url=&#x22;, también se puede indicar un atajo de teclado para activar la revisión con HERA.';
$texto['help_img_integrai3'] = 'Detalle del cuadro de diálogo para añadir herramientas al Web Developer'; 
$texto['help_integra_i4'] = 'Y ya está. A partir de entonces, bastará con pulsar con el botón derecho del ratón sobre la página que se esté visitando y seleccionar: <span xml:lang="en" lang="en">Web Developer</span> &#x3E;&#x3E; <span xml:lang="en" lang="en">Tools</span> &#x3E;&#x3E; HERA, o pulsar la combinación de teclas indicadas para el atajo antes definido, y se iniciará la revisión.';
$texto['help_img_integrai4'] = 'Detalle del menú contextual Web Developer con HERA integrada'; 
$texto['help_integra_j'] = '(Las imágenes que ilustran este proceso han sido cedidas por <a href="http://www.torresburriel.com/weblog/index.php?p=547">Daniel Torres Burriel</a>.)';
$texto['help_h4_integra3'] = 'Añadir HERA a <span xml:lang="en" lang="en">Opera W3-Dev Menu</span>';
$texto['help_integra_k'] = '<a href="http://tobyinkster.co.uk/" hreflang="en">Toby Inkster</a> ha creado un menú especial para desarrolladores que utilizan Opera. El <a href="http://tobyinkster.co.uk/opera" hreflang="en">Opera W3-Dev Menu</a>, ofrece acceso directo a herramientas de revisión y documentación de interés sobre estándares, accesibilidad y usabilidad (Por el momento todo está en inglés, pero estamos traduciéndolo).';
$texto['help_img_9'] = 'Detalle del menú para desarrolladores de Opera con HERA integrada en él.';
$texto['help_integra_l'] = 'El menú se instala directamente desde la página de descarga y puede agregarse HERA muy fácilmente a él. Para ello, una vez instalado, basta con editar el fichero &#x22;v3dev-1.99.ini&#x22; que se encontrará en la carpeta &#x22;menu&#x22; del directorio &#x22;profile&#x22; de la instalación de Opera. (Como la instalación puede ser muy distinta según la configuración del sistema operativo, lo más sencillo será localizar el fichero mediante el buscador del sistema).';
$texto['help_integra_m'] = 'Una vez localizado el fichero, puede abrirse con cualquier editor de texto, y en la línea 55 pegar la siguiente cadena de texto: &#xAB;Item, "HERA" = Go to page, "http://www.sidar.org/hera/?url=%u"&#xBB;. Si el editor no muestra los números de línea, basta con localizar el texto: &#xAB;[Actions Menu]&#xBB; y pegar la cadena antes mencionada tras: &#x22;----1&#x22;. Esta operación no debe hacerse teniendo Opera abierto. Una vez editado el fichero, puede abrirse Opera y aparecerá el menú con el acceso directo a HERA que permitirá revisar la página que estemos visitando en ese momento.';

$texto['help_g'] = 'Si tiene dudas sobre cómo efectuar las revisiones o sugerencias para mejorar esta herramienta, envíe un mensaje a: <a href="mailto:hera@sidar.org">hera@sidar.org</a>.';

$texto['info_h1'] = 'Información sobre HERA';

$texto['info_indice'] = '
<ol class="indice">
	<li><a href="#info_intro">Introducción</a></li>
	<li><a href="#info_princi">Principio y fin</a></li>
	<li><a href="#info_cola">Colaborar</a></li>
	<li><a href="#info_reco">Reconocimientos</a></li>
	<li><a href="#info_traduc">Traductores</a></li>
</ol>';

$texto['info_a'] = 'La <a href="http://www.sidar.org/">Fundación Sidar</a> pone a disposición de la comunidad de desarrolladores, diseñadores y público en general, de forma gratuita, esta herramienta para facilitar la revisión de la accesibilidad de las páginas y sitios Web. <strong>HERA</strong> ha sido diseñada y desarrollada por <a href="http://www.sidar.org/que/ge/cb.php">Carlos Benavídez</a>, con la colaboración de <a href="http://www.sidar.org/que/ge/egyr.php">Emmanuelle Gutiérrez y Restrepo</a> y <a href="http://www.sidar.org/que/ge/cmccn.php">Charles McCathieNevile</a>, especialmente para la <strong>Fundación Sidar</strong>.';
$texto['info_h2_sobre'] = 'Principio y fin';
$texto['info_origen'] = '¿De dónde viene el nombre de <strong>HERA</strong>? A principios del año 2003, la Fundación Sidar lanzó <a href="http://www.sidar.org/edipo/">Edipo</a>, una herramienta para la creación de hojas de estilo personales y, ya en aquel momento, pensamos en la creación de una utilidad "hermana" basada en la aplicación de hojas de estilo para facilitar la revisión de la accesibilidad. Dado que Edipo es el nombre de un personaje mitológico, buscamos uno similar para esta nueva aplicación y surgió el de HERA que, además de ser el de otro personaje femenino, conforma el acrónimo de: Hojas de Estilo para la Revisión de la Accesibilidad. La primera versión de HERA se basaba precisamente en la aplicación de hojas de estilo para facilitar la revisión manual de la accesibilidad. Esta nueva versión ya no depende de ello, pues queríamos que pudiese funcionar en cualquier navegador, incluso en aquellos que no soportan algunas propiedades de las hojas de estilo, pero tras consultar con los usuarios decidimos mantener el nombre de HERA.';
$texto['info_define'] = 'El objetivo de <strong>HERA</strong> es facilitar el trabajo a quienes desean o tienen la misión de revisar la accesibilidad de una página o sitio Web. La revisión de la accesibilidad nunca puede estar completa sin una revisión manual. Las herramientas de revisión automática sólo pueden detectar determinados elementos y atributos pero no pueden asegurar que se estén utilizando apropiadamente. Por tanto, es imprescindible la participación de un ser humano que pueda comprobar los elementos y atributos que no pueden ser revisados automáticamente y si se están aplicando correctamente las directrices de accesibilidad.';
$texto['info_difiere'] = 'Por tanto, <strong>HERA</strong> es una herramienta para la revisión <strong>manual</strong> de la accesibilidad, aunque esta nueva versión ofrece a la vez la <strong>revisión automática</strong> de manera que ahorra trabajo al revisor, indicándole qué puntos con seguridad están fallando, cuáles con seguridad están bien, cuáles no son aplicables en esa página en concreto y, qué puntos necesariamente deben ser revisados por un humano.';
$texto['info_proceso'] = '<strong>HERA</strong> facilita al revisor la localización de los errores mediante una vista de la página con los elementos a revisar destacados mediante íconos, recuadros de color y, generalmente, el código de cada elemento; otra vista del código fuente de la página pero en el que se destacan los elementos susceptibles de contener error; una herramienta adicional para la revisión del contraste de los colores usados, y vistas complementarias de la página y su código fuente. Además, ofrece instrucciones en línea sobre en qué tiene que fijarse el revisor cuando analiza la aplicación de cada punto, recordatorios de ello en las vistas y una ayuda complementaria y extensa que incluirá, en su versión definitiva, ejemplos gráficos de la aplicación de las Directrices de Accesibilidad. En la página de Ayuda encontrará más información sobre cómo funciona HERA.';
$texto['info_h2cola'] = 'Colaborar';
$texto['info_b'] = '<strong>HERA</strong> es una utilidad escrita en <acronym title="Hypertext Preprocessor" lang="en">PHP</acronym> y, como todos los proyectos de la <strong>Fundación Sidar</strong>, es una aplicación de código abierto, en cuyo desarrollo puede colaborar cualquier persona aportando mejoras, modificaciones, traducciones, corrección de errores, documentación, etcétera. Para ponerse en contacto con el Equipo Desarrollador, envíe un mensaje a: <a href="mailto:hera@sidar.org">hera@sidar.org</a>.';
$texto['info_c'] = 'El <a href="%s" title="Código fuente de HERA.">código fuente</a> de <strong>HERA</strong> se distribuye bajo los términos de la <a href="http://www.sidar.org/legal/2003/gpl.html">Licencia Pública General</a> (<acronym title="Licencia Pública General">GPL</acronym>) de la <a href="http://www.gnu.org/philosophy/license-list.html#GPLCompatibleLicenses" hreflang="en"></a><span lang="en" style="font-style:italic">Free Software Foundation</span> y la definición de  <a href="http://www.opensource.org/docs/definition.php" hreflang="en"><span lang="en">Open Source</span></a>. Si necesita más información sobre el concepto de "software libre", puedes leer nuestra <a href="http://www.sidar.org/legal/2003/copy.php">licencia de software</a>.';
$texto['info_d'] = 'Por otra parte, confiamos en que quienes utilicen <strong>HERA</strong> como apoyo de sus revisiones, ya sean personales o profesionales, con o sin ánimo de lucro, declaren su uso. Puede utilizar estos íconos, que se muestran cuando el revisor indica que la página cumple con un determinado nivel de prioridad.';
$texto['info_masicos'] = 'En la página de Ayuda encontrará iconos opcionales que quizás convengan más al estilo de su página y que podrá, incluso, personalizar.';
$texto['info_e'] = 'Sugerimos que los iconos enlacen con el informe generado con HERA y que en él se proporcionen los datos de la persona que efectuó la revisión y la fecha en que la realizó. También, ya que se pueden producir errores al modificar las páginas, sería deseable que el ícono represente el compromiso de mantener la calidad alcanzada y de solucionar cualquier inconveniente que pueda detectarse.';
$texto['info_h2'] = 'Reconocimientos';
$texto['info_f'] = 'Muchos han contribuido, en una u otra forma, al desarrollo de <strong>HERA</strong>. Principalmente aquellos integrantes y colaboradores del <strong>Sidar</strong> que conforman su principal grupo de trabajo: <strong>Emmanuelle Gutiérrez y Restrepo</strong>, <strong>Charles McCathieNevile</strong>, <strong>Loïc Martínez Normand</strong>, <strong>Rafael Romero</strong> y <strong>Jorge Fernandes</strong>.';
$texto['info_g'] = 'El grupo de personas que realizó las primeras pruebas sobre <strong>HERA</strong>: <strong>Martín Baldassarre</strong>, <strong>Vincent Tabard</strong>, <strong>David Arango</strong>, <strong>Fernando Gutiérrez</strong>, <strong>José Luis Fuertes</strong> y <strong>Tom Croucher</strong>.';
$texto['info_h'] = '<strong>Daniel Low</strong> aportó los primeros consejos como usuario y <strong>Ramiro Benavídez</strong> trabajó en el desarrollo de la utilidad para revisar el contraste de colores.';
$texto['info_i'] = '<strong>Olivier Plathey</strong> proporcionó <a href="http://www.fpdf.org/">FPDF</a>, que permite generar documentos PDF directamente desde PHP.';
$texto['info_h2tradu'] = 'Traducciones';
$texto['info_a_1'] = '<strong>HERA</strong> está siendo traducida a varios idiomas dado que su uso ha despertado el interés internacional.'; 
$texto['info_trada'] = 'La traducción al %s está a cargo de:';
$texto['info_tracola'] = 'Si desea colaborar traduciendo a estos u otros idiomas, por favor, envíe un mensaje a <a href="mailto:transhera@sidar.org" title="Envía un mensaje a la lista de traductores de HERA.">transhera@sidar.org</a>.';

$texto['code_h1'] = 'Código fuente de HERA';
$texto['code_p'] = 'Los archivos se pueden ver/descargar individualmente. Si desea hacer alguna consulta al respecto, por favor, envíe un mensaje a: <a href="mailto:hera@sidar.org">hera@sidar.org</a>.';
$texto['code_op_a'] = 'Ver';
$texto['code_op_b'] = 'Descargar';
$texto['code_li_a'] = '<em>Directorio /inc/...</em><br /><span class="small">Archivos incluidos dinámicamente.</span>';
$texto['code_li_b'] = '<em>Directorio /lang/...</em><br /><span class="small">Cada traducción se ubica en un directorio identificado con el código del idioma.</span>';
$texto['code_1'] = 'La página de inicio de cada idioma se identifica usando como extensión su código de idioma.';
$texto['code_2'] = 'Muestra la página (en modo gráfico o código) destacando los elementos a verificar manualmente.';
$texto['code_3'] = 'Genera el informe en XHTML, RDF o PDF, para imprimir o descargar.';
$texto['code_4'] = 'Utilidad adicional para comprobar el contraste de los colores de la página.';
$texto['code_5'] = 'Hoja de estilo.';
$texto['code_6'] = 'Hoja de estilo utilizada en las vistas de la página.';
$texto['code_7'] = 'Algunas funciones básicas.';
$texto['code_8'] = 'Decide las acciones a tomar, escribe la cabecera y el pie de página.';
$texto['code_9'] = 'Obtiene el contenido de la página a revisar.';
$texto['code_10'] = 'Analiza el contenido de la página y obtiene los resultados automáticos.';
$texto['code_11'] = 'Muestra el resumen de resultados y el sistema de navegación (por puntos o por pautas).';
$texto['code_12'] = 'Muestra los puntos de control y las herramientas para la revisión manual.';
$texto['code_13'] = 'Listado de nombres de los elementos revisados.';
$texto['code_14'] = 'Textos de ayuda para cada item de los puntos de control.';
$texto['code_15'] = 'Textos para la interfaz de HERA.';
$texto['code_16'] = 'Textos del manual de instrucciones para los puntos de control.';
$texto['code_17'] = 'Textos de las indicaciones en la vistas de página.';
$texto['code_18'] = 'Textos de las Pautas de Accesibilidad del Contenido en la Web 1.0.';
$texto['code_19'] = 'Información sobre los ítems de cada punto de control.';
$texto['code_20'] = 'Textos de otras páginas.';
$texto['thanks_h1'] = '¡Gracias por su donación!';
$texto['thanks_a'] = 'Gracias por su apoyo. Su transacción ha finalizado y le hemos enviado un recibo de su donación por correo electrónico. Puede acceder a su cuenta, www.paypal.com/, para ver los detalles de esta transacción.';
$texto['thanks_b'] = 'Su contribución ayudará a que podamos seguir ofreciendo herramientas de calidad y gratuitas para todos. Con su apoyo podremos seguir mejorando y manteniendo esta herramienta. Y así, usted contribuye, directamente, a que cada día, la Sociedad de la Información sea un poco más accesible e inclusiva para todos. ';
$texto['thanks_c'] = 'Su donaci&oacute;n puede permanecer en el anonimato o, si lo desea, puede enviar un mensaje a <a href="mailto:donantes@sidar.org">donantes@sidar.org</a> con copia de la transacci&oacute;n de donaci&oacute;n y publicaremos sus datos en la <a href="http://www.sidar.org/donatable.php">Tabla de Donantes</a>.';
?>