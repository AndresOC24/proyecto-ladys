UNIVERSIDAD PRIVADA “FRANZ TAMAYO”
FACULTAD DE INGENIERÍA
CARRERA DE INGENIERÍA DE SISTEMAS
PROYECTO DE GRADO
Sistema de validación administrativa de identidad y documentación
para el registro de usuarias en sistemas de transporte privado
orientado a mujeres, basado en reconocimiento facial y OCR. Caso
de estudio: Lady 's on Go, Santa Cruz de la Sierra.”
POSTULANTE:
Bianca Sthefania Aguilar
Duran
TUTOR:
Ing. Carlos Draugialis
Pessoa
SANTA CRUZ DE LA SIERRA-BOLIVIA
2026

Declaración de idoneidad
Yo, Bianca Sthefania Aguilar Duran identificada como estudiante regular de esta
universidad, declaró que este Proyecto final de grado es original y auténtico y no es
copia de ningún otro, bajo mi responsabilidad, y autorizo a la Universidad Privada
Franz Tamayo para su divulgación.
……FIRMAR CON AZÚL……….
Bianca Sthefania Aguilar Duran
C.I. 12351006 S.C.

AUTORIDADES UNIVERSIDAD PRIVADA FRANZ TAMAYO
SEDE SANTA CRUZ DE LA SIERRA
ARQ. DESA VERÓNICA AGREDA DE PAZOS
RECTORA NACIONAL
DR. CARLOS DABDOUB ARRIEN
VICERRECTOR SEDE SANTA CRUZ
MSC. CRISTHIAN FABIAN URIONA HERRERA
DECANO ACADÉMICO
ING. HERMAN MARCELO PACHECO USTAREZ
DIRECTOR DE CARRERA – INGENIERÍA DE SISTEMAS

DEDICATORIA
Se lo dedico a:
A mis padres, Martin Aguilar Ramirez y Maria Elia Duran Mano. Gracias por su amor
incondicional, por ser mi mayor fortaleza en cada etapa de este camino universitario y por
enseñarme que la perseverancia y el esfuerzo siempre dan sus frutos. Este logro es tan mío
como suyo.
A mi tía, Brigida Duran Mano, por su cariño y por ser un gran apoyo inquebrantable para mí.
Gracias por creer en mis sueños y acompañarme en este proceso.
A mis fieles compañeros, Otto, Lara y Mafalda. Gracias por ser esa compañía silenciosa en
mis noches de estudio y desvelo, aliviando el cansancio y acompañándome en cada
madrugada de trabajo frente a la computadora.
Con amor y gratitud.
Bianca Sthefania Aguilar Duran.

AGRADECIMIENTOS
A Dios, por guiar cada paso de mi camino, por la fortaleza en los momentos difíciles y por
permitirme llegar hasta esta etapa de mi vida.
A mi familia, especialmente a mis padres, por su apoyo incondicional, su paciencia y su
confianza durante todos estos años de formación. Sin ellos este logro no habría sido
posible.
A mi tutor, el Ing. Carlos Draugialis Pessoa, por su valioso aporte en el desarrollo de este
proyecto y por su dedicación como docente a lo largo de la carrera. Su enseñanza clara, su
orientación oportuna y su exigencia académica han marcado profundamente mi formación
profesional.
A la Ing. Giovanna Alvares Gonzales, por compartir generosamente sus conocimientos y por
su valiosa enseñanza a lo largo de mi carrera, inspirándome a ser mejor profesional.
Al Ing. Alejandro Rodriguez, por brindarme sus conocimientos, por su dedicación y por su
vocación de enseñar de verdad, dejando una huella importante en mi aprendizaje.
A la Universidad Privada Franz Tamayo, mi casa de estudios, por brindarme las
herramientas, el conocimiento y el espacio para desarrollarme como profesional en
Ingeniería de Sistemas.
Al área de Servicios Estudiantiles, donde tuve la oportunidad de formarme como becaria, y
de manera especial a la Lic. Fabiola Rojas, por su confianza, su apoyo constante y por ser
una persona importante en mi proceso universitario.
Al área de Tecnologías de la Información, donde también tuve el privilegio de ejercer como
becaria, y de manera particular al Ing. Miguel Flores Valda, por compartir su experiencia,
sus enseñanzas y por contribuir significativamente a mi crecimiento técnico y profesional.
Atentamente,
Bianca Sthefania Aguilar Duran.

ÍNDICE
CAPÍTULO I.............................................................................................................................1
MARCO GENERAL Y METODOLÓGICO...............................................................................1
1. Introducción..................................................................................................................1
1.2. Planteamiento del problema....................................................................................7
1.3. Árbol de problemas.............................................................................................9
1.4. Formulación del problema...............................................................................10
1.5. Problemas secundarios....................................................................................10
1.6. Objetivos..................................................................................................................11
1.7. Justificaciones........................................................................................................12
1.7.2. Justificación Social........................................................................................12
1.7.3. Justificación Técnica.....................................................................................13
1.7.4. Justificación Metodológica...........................................................................14
1.8. Delimitación.............................................................................................................15
1.8.1. Delimitación temporal....................................................................................15
1.8.2. Delimitación Espacial....................................................................................15
1.8.3. Delimitación Temática....................................................................................15
1.9. Metodología.............................................................................................................16
1.10. Métodos y Técnicas........................................................................................17
1.10.1. Encuesta estructurada...........................................................................17
1.10.2. Consulta a experta.................................................................................17
1.11. Metodología de Desarrollo...................................................................................17
Capítulo II. Marco Teórico....................................................................................................19
2. Marco Teórico.............................................................................................................20
2.1. Sistema...............................................................................................................20
2.2. Sistema Web......................................................................................................21
2.3. API Rest..............................................................................................................22
2.4. Frontend.............................................................................................................23
2.5. Backend.............................................................................................................24
2.6. Modelo Vista Controlador (MVC).....................................................................24
2.7. Inteligencia Artificial.........................................................................................25
2.8. Aprendizaje Automático (Machine Learning).................................................26
2.9. Aprendizaje Profundo (Deep Learning)...........................................................26
2.10. Redes Neuronales Convolucionales (CNN)..................................................27
2.11. Visión por Computadora.................................................................................28
2.12. Reconocimiento de Patrones.........................................................................29
2.13. Biometría..........................................................................................................30
2.14. Reconocimiento Facial...................................................................................31
2.15. Verificación Facial 1:1 e Identificación Facial 1:N........................................32
2.16. Suplantación de Identidad y Spoofing..........................................................33
2.17. Verificación Documental.................................................................................33
2.18. Reconocimiento Óptico de Caracteres (OCR)..............................................34
2.19. Parámetros de Control y Validación de Estructura Documental................35

2.20. Cédula de Identidad Boliviana.......................................................................35
2.21. eKYC (Electronic Know Your Customer).......................................................36
2.22. PHP y Laravel..................................................................................................37
2.23. Blade.................................................................................................................37
2.24. MySQL y Bases de Datos Relacionales........................................................38
2.25. Python y FastAPI.............................................................................................38
2.26. OpenCV, DeepFace y Librerías de OCR........................................................39
2.27. Seguridad Informática y la Triada CID...........................................................39
2.28. Metodología Ágil.............................................................................................40
2.29. Scrum...............................................................................................................41
2.30. Extreme Programming (XP)............................................................................42
2.31. Embedding Facial (Vector Facial)..................................................................43
2.32. Validación Administrativa Híbrida.................................................................43
2.33. Marco Referencial.................................................................................................44
2.33.1. Lady´s On Go: Propuesta de iniciativa......................................................44
2.33.2. Misión............................................................................................................45
2.33.3. Visión.............................................................................................................45
2.33.4. Servicio Propuesto.......................................................................................45
2.33.5. Zona de operación.......................................................................................45
Capítulo III. Ingeniería del Proyecto...................................................................................46
3. Ingeniería del Proyecto..............................................................................................47
3.1. Análisis del proyecto........................................................................................47
3.2. Recolección de Requisitos...............................................................................48
3.2.1. Requisitos Funcionales...........................................................................48
3.2.2. Requisitos No funcionales......................................................................57
3.3. Historias de usuario..........................................................................................66
3.4. Casos de Uso.....................................................................................................75
3.4.1. Identificación de actores........................................................................75
3.4.2. Casos de Uso del Sistema.......................................................................75
3.5. Modelo de reconocimiento facial.....................................................................88
3.5.1. Captura......................................................................................................88
3.5.2. Detección de Vida.....................................................................................89
3.5.3. Detección y alineación.............................................................................89
3.5.4. Extracción de embeddings......................................................................89
3.5.5. Comparación y veredicto.........................................................................89
3.6. Product Backlog................................................................................................91
3.7. Análisis FODA...................................................................................................92
3.8. Diseño detallado................................................................................................93
3.9. Tablas y campos................................................................................................94
3.10. Relaciones entre tablas..................................................................................96
Capítulo IV.............................................................................................................................98
Estudio de Factibilidad........................................................................................................98
4. Factibilidad Técnica...................................................................................................99
4.1. Factibilidad técnica...........................................................................................99

4.2. Factibilidad operativa.......................................................................................99
4.3. Factibilidad económica...................................................................................100
4.3.1. Estimación del tamaño del software....................................................100
4.3.2. Modelo COCOMO II................................................................................100
4.3.3. Estimación de costos.............................................................................103
4.3.4. Análisis comparativo de la estimación................................................104
Capítulo V............................................................................................................................106
Conclusiones y Recomendaciones..................................................................................106
5. Conclusiones............................................................................................................107
5.1. Recomendaciones.................................................................................................108
Capítulo VI..........................................................................................................................109
Referencias Bibliográficas................................................................................................109
6. Referencias...............................................................................................................110
Anexos...........................................................................................................................111
Resultados de las encuestas.................................................................................111
Entrevista a experta del área tecnológica............................................................125

ÍNDICE DE ILUSTRACIONES
Ilustración 1: Árbol de problemas........................................................................................9
Ilustración 2: Elementos básicos de un sistema..............................................................20
Ilustración 3: Modelo Cliente-Servidor..............................................................................21
Ilustración 4: Modelo API REST..........................................................................................22
Ilustración 5: Arquitectura Fronted....................................................................................23
Ilustración 6: Componentes del Backend..........................................................................24
Ilustración 7: Patrón Modelo Vista Controlador (MVC)....................................................25
Ilustración 8: Arquitectura de Redes Neuronales Convolucionales...............................27
Ilustración 11: Tipos de Biometría......................................................................................30
Ilustración 12: Proceso de Extracción de Características Faciales................................31
Ilustración 13: Verificación de Identidad y Seguridad......................................................32
Ilustración 14: Flujo de Reconocimiento Óptico de Caracteres (OCR)..........................34
Ilustración 15: Cédula de identidad Boliviana (Anverso y Reverso)...............................36
Ilustración 16: Triada CID de Seguridad de la Información.............................................40
Ilustración 17: Ciclo de Metodologías Ágiles....................................................................41
Ilustración 18: Marco de Trabajo SPRINT (SCRUM).........................................................42
Ilustración 19: Product Backlog.........................................................................................91
ÍNDICE DE DIAGRAMAS
Diagrama 1: Caso de uso – Autenticación al Sistema......................................................81
Diagrama 2: Caso de uso: Registro y verificación de identidad.....................................81
Diagrama 3: Caso de uso – Gestión de revisiones administrativas...............................82
Diagrama 4 — Registro de pasajera...................................................................................82
Diagrama 5 — Registro de conductora..............................................................................83
Diagrama 6 — Validación del Vehículo..............................................................................84
Diagrama 7 — Gestión de revisiones administrativas.....................................................85
Diagrama 8 — Gestión de usuarias del sistema...............................................................85
Diagrama 9 — Configuración de parámetros del sistema...............................................86
Diagrama 10 — Gestión de perfil de usuaria.....................................................................87
Diagrama 11 — Generación de reportes............................................................................87
Diagrama 12 — Auditoría y trazabilidad............................................................................88
Diagrama 13 — Diseño de la Base de Datos.....................................................................94

ÍNDICE DE TABLAS
Tabla 1: Requerimiento Funcional 1...................................................................................48
Tabla 2: Requerimiento Funcional 2...................................................................................49
Tabla 3: Requerimiento Funcional 3...................................................................................49
Tabla 4: Requerimiento Funcional 4...................................................................................50
Tabla 5: Requerimiento Funcional 5...................................................................................50
Tabla 6: Requerimiento Funcional 6...................................................................................51
Tabla 7: Requerimiento Funcional 7...................................................................................51
Tabla 8: Requerimiento Funcional 8...................................................................................52
Tabla 9: Requerimiento Funcional 9...................................................................................52
Tabla 10: Requerimiento Funcional 10...............................................................................53
Tabla 11: Requerimiento Funcional 11...............................................................................53
Tabla 12: Requerimiento Funcional 12...............................................................................54
Tabla 13: Requerimiento Funcional 13...............................................................................54
Tabla 14: Requerimiento Funcional 14...............................................................................55
Tabla 15: Requerimiento Funcional 15...............................................................................55
Tabla 16: Requerimiento Funcional 16...............................................................................56
Tabla 17: Requerimiento Funcional 17...............................................................................56
Tabla 18: Requerimiento No Funcional 1...........................................................................57
Tabla 19: Requerimiento No Funcional 2...........................................................................57
Tabla 20: Requerimiento No Funcional 3...........................................................................58
Tabla 21: Requerimiento No Funcional 4...........................................................................58
Tabla 22: Requerimiento No Funcional 5...........................................................................59
Tabla 23: Requerimiento No Funcional 6...........................................................................59
Tabla 24: Requerimiento No Funcional 7...........................................................................60
Tabla 25: Requerimiento No Funcional 8...........................................................................60
Tabla 26: Requerimiento No Funcional 9...........................................................................61
Tabla 27: Requerimiento No Funcional 10.........................................................................61
Tabla 28: Requerimiento No Funcional 11.........................................................................62
Tabla 29: Requerimiento No Funcional 12.........................................................................62
Tabla 30: Requerimiento No Funcional 13.........................................................................63
Tabla 31: Requerimiento No Funcional 14.........................................................................63
Tabla 32: Requerimiento No Funcional 15........................................................................64
Tabla 33: Requerimiento No Funcional 16.........................................................................64
Tabla 34: Requerimiento No Funcional 17.........................................................................65
Tabla 35: Historia de Usuario 1...........................................................................................66
Tabla 36: Historia de Usuario 2...........................................................................................66
Tabla 37: Historia de Usuario 3...........................................................................................67
Tabla 38: Historia de Usuario 4...........................................................................................67
Tabla 39: Historia de Usuario 5...........................................................................................68
Tabla 40: Historia de Usuario 6...........................................................................................68
Tabla 41: Historia de Usuario 7...........................................................................................69
Tabla 42: Historia de Usuario 8...........................................................................................69

Tabla 43: Historia de Usuario 9...........................................................................................70
Tabla 44: Historia de Usuario 10.........................................................................................70
Tabla 45: Historia de Usuario 11.........................................................................................71
Tabla 46: Historia de Usuario 12.........................................................................................71
Tabla 47: Historia de Usuario 13.........................................................................................72
Tabla 48: Historia de Usuario 14.........................................................................................72
Tabla 49: Historia de Usuario 15.........................................................................................73
Tabla 50: Historia de Usuario 16.........................................................................................73
Tabla 51: Historia de Usuario 17.........................................................................................74
Tabla 52: Caso de Uso - Autenticación al Sistema...........................................................75
Tabla 53: Caso de uso – Registro y verificación de identidad.........................................76
Tabla 54: Caso de uso – Registro de pasajera..................................................................76
Tabla 55: Caso de uso – Registro de conductora.............................................................77
Tabla 56: Caso de uso – Validación del vehículo..............................................................77
Tabla 57: Caso de uso – Gestión de revisiones administrativas.....................................78
Tabla 58: Caso de uso – Gestión de usuarias del sistema...............................................78
Tabla 59: Caso de uso – Configuración de parámetros del sistema...............................79
Tabla 60: Caso de uso – Gestión de perfil de usuaria......................................................79
Tabla 61: Caso de uso – Generación de reportes.............................................................80
Tabla 62: Caso de uso – Auditoría y trazabilidad..............................................................80
Tabla 63 : Salario personal................................................................................................103
Tabla 64: Detalle de Servicios Básicos............................................................................103
Tabla 65 : Salario personal Costo real del desarrollo (5 meses)...................................104
Tabla 66 : Costo total.........................................................................................................104

RESUMEN
El presente proyecto aborda la falta de mecanismos confiables de verificación de identidad
en el registro de usuarios de las plataformas de transporte privado, una deficiencia que en
Santa Cruz de la Sierra afecta de manera particular a las mujeres. La investigación de
Ameller y Sandoval (2022) evidencia que en la ciudad siete de cada diez mujeres atraviesan
situaciones de violencia en el transporte con una frecuencia diaria o semanal, y según el
Observatorio Boliviano de Seguridad Ciudadana (2025) el departamento se ubica
consistentemente entre los tres con mayor número de denuncias por violencia de género del
país. Las plataformas de transporte privado disponibles en el mercado local, permiten que
cualquier persona se registre como conductor o pasajero sin una validación efectiva de su
identidad real, lo que abre la puerta a la suplantación de identidad y a situaciones de riesgo
que pueda prevenirse.
Frente a esta problemática, el proyecto propone el desarrollo de un sistema de validación de
identidad y documentación que constituye la primera etapa de control y seguridad de una
plataforma de transporte. El sistema se concentra en dos elementos: la persona y su
documentación. Respecto de la persona, mediante reconocimiento facial verifica que quien
se registra corresponde al titular del documento presentado; respecto de la documentación,
mediante reconocimiento óptico de caracteres (OCR) extrae y valida la información de la
cédula de identidad, identificando los parámetros de control que permiten detectar
documentos falsos o adulterados y reemplazar la verificación manual por un proceso
automatizado. El alcance se limita a esta fase de registro y verificación de conductoras y
clientes, dejando fuera las funciones operativas de gestión de viajes.
El desarrollo se gestiona con la metodología ágil Scrum, que permite construir el
sistema de forma iterativa y validar entregas funcionales al cierre de cada sprint. El
sistema se valida tomando como caso de estudio Lady 's On Go, iniciativa de
transporte exclusivo para mujeres en el cuarto anillo de Santa Cruz de la Sierra. Así,
el proyecto propone una herramienta basada en inteligencia artificial que, mediante su
implementación en las plataformas de transporte privado, contribuye a reducir el
principal vacío de seguridad de su proceso de registro y aporta a una movilidad
urbana más confiable para las mujeres cruceñas.
Palabras clave: verificación de identidad, reconocimiento facial, OCR, registro de usuarios,
transporte urbano, suplantación de identidad, seguridad, mujeres, Santa Cruz de la Sierra.

ABSTRACT
This project addresses the lack of reliable identity verification mechanisms in the user
registration process of private transportation platforms, a deficiency that in Santa Cruz de la
Sierra particularly affects women. Ameller and Sandoval (2022) show that seven out of ten
women in the city experience violence while using transport on a daily or weekly basis, and
according to the Bolivian Observatory of Citizen Security (2025) the department consistently
ranks among the three with the highest number of gender-based violence reports in the
country. The private transportation platforms available in the local market allow anyone to
register as a driver or passenger without an effective validation of their real identity, opening
the door to identity fraud and preventable risk situations.
In response, the project proposes the development of an identity and document validation
system that serves as the first control and security stage of a transportation platform. The
system focuses on two elements: the person and their documentation. Regarding the
person, facial recognition verifies that the registrant matches the holder of the submitted
document; regarding the documentation, Optical Character Recognition (OCR) extracts and
validates the information on the identity card, identifying the control parameters needed to
detect forged or altered documents and to replace manual verification with an automated
process. The scope is limited to this registration and verification phase for drivers and
clients, excluding ride management functions.
The development is managed under the Scrum agile methodology, which enables the
system to be built iteratively and to deliver functional increments at the end of each sprint.
The system is validated using Lady's On Go as a case study, a transportation initiative
exclusively for women in the fourth ring of Santa Cruz de la Sierra. In this way, the project
proposes an artificial intelligence-based tool that, through its implementation in private
transportation platforms, contributes to reducing the main security gap in their registration
process and supports a more reliable urban mobility for women in Santa Cruz.
Keywords: identity verification, facial recognition, OCR, user registration, urban transport,
identity fraud, security, women, Santa Cruz de la Sierra

CAPÍTULO I
MARCO GENERAL Y METODOLÓGICO

1. Introducción
Moverse por la ciudad de forma segura es una condición básica para acceder al
trabajo, al estudio y a la vida social; sin embargo, para muchas mujeres ese
desplazamiento cotidiano sigue marcado por el miedo. Las plataformas tecnológicas
de transporte privado como Uber, InDrive y Yango se han convertido en una
herramienta de uso diario para organizar la movilidad en las ciudades, al punto de
estructurar buena parte de cómo las personas se trasladan hoy. No obstante, sus
beneficios no han alcanzado por igual a todos los usuarios: las mujeres continúan
enfrentando situaciones de inseguridad, acoso y violencia tanto en el transporte
público como en el privado, lo que limita su libertad de movimiento y afecta
directamente su calidad de vida.
En Bolivia, esta problemática alcanza dimensiones alarmantes. Según datos de la
Fiscalía General del Estado, durante la gestión 2024 se registraron 50.325 casos de
violencia contra mujeres y menores, así como 84 feminicidios y 34 infanticidios a
nivel nacional. De acuerdo con la Encuesta de Demografía y Salud 2023 publicada
por el Instituto Nacional de Estadística (INE), aproximadamente 900 mil mujeres
entre 15 y 49 años en Bolivia son sobrevivientes de violencia basada en género, lo
que equivale a cerca de una de cada tres mujeres en ese rango etario
(aproximadamente el 33%), y solamente el 17% de las víctimas presenta una
denuncia formal (UNFPA Bolivia, 2025). El departamento de Santa Cruz se posiciona
consistentemente entre los tres departamentos con mayor número de denuncias del
país e, incluso, durante el primer semestre de 2025 concentró el 50,19% de las
víctimas de delitos contra la vida a nivel nacional (Observatorio Boliviano de
Seguridad Ciudadana, 2025).
En el ámbito específico del transporte, la situación no es menos preocupante. La
investigación de Ameller y Sandoval (2022), publicada en la revista Aportes,
evidencia que en Santa Cruz de la Sierra siete de cada diez mujeres sufren violencia
en el transporte público con una frecuencia entre diaria y semanal. A esta realidad
se suma un vacío estructural en el transporte privado: las plataformas disponibles en
el mercado local, permiten que cualquier persona se registre como conductor o
pasajero sin pasar por una validación efectiva de su identidad real.

La ausencia de mecanismos rigurosos de verificación convierte el proceso de
registro en el principal punto débil de seguridad de estas plataformas. Que este
riesgo no es hipotético lo confirman casos concretos ocurridos en el país: en Bolivia,
un conductor de InDrive fue aprehendido tras ser denunciado por violar a tres de sus
pasajeras, una de ellas menor de 15 años (Red Uno, 2023); y en Santa Cruz, la
Fuerza Especial de Lucha Contra la Violencia (FELCV) detuvo a un conductor que,
tras un viaje solicitado por aplicación, drogó a cuatro pasajeros y abusó sexualmente
de una de las mujeres del grupo (Todo Taxi, 2025). Si bien existen iniciativas locales
de transporte exclusivo para mujeres, como Móvil Rosa, estas operan de manera
informal, sin una plataforma tecnológica que integre la verificación de identidad como
mecanismo de control.
Frente a esta realidad, el presente proyecto propone el desarrollo de un sistema de
validación de identidad y documentación para el registro de usuarias en sistemas de
transporte privado. El sistema constituye la primera etapa de control y seguridad de
una plataforma de transporte y se concentra en dos elementos fundamentales: la
persona y su documentación. Mediante reconocimiento facial, verifica que quien se
registra corresponde efectivamente al titular del documento presentado; mediante
reconocimiento óptico de caracteres (OCR), extrae y valida la información de la
cédula de identidad, identificando los parámetros de control que permiten detectar
documentos falsos o adulterados. De esta manera, el proceso de verificación que
hoy se realiza de forma manual o que sencillamente no se realiza se reemplaza por
un procedimiento automatizado, riguroso y verificable, complementado con una
revisión administrativa cuando la verificación automatizada presenta dudas, aplicable
tanto al registro de conductoras como al de pasajeras.
El alcance del proyecto se delimita de manera deliberada a esta fase de registro y
verificación, dejando fuera las funciones operativas de gestión de viajes, que
corresponden a etapas posteriores de desarrollo. El sistema se desarrolla tomando
como caso de estudio Lady 's On Go, propuesta de iniciativa de transporte privado
exclusivo para mujeres en la zona del cuarto anillo de Santa Cruz de la Sierra, área
que concentra una alta densidad poblacional y una demanda significativa de
servicios de transporte privado. La gestión del proyecto se realiza mediante la
metodología ágil Scrum en combinación con prácticas de Extreme Programming
(XP), enfoque que permite organizar el trabajo en ciclos cortos llamados sprints, con
entregas funcionales y verificables al finalizar cada iteración.

A través de este proyecto se busca demostrar que la verificación de identidad
basada en inteligencia artificial, cuando se diseña con un propósito social claro,
puede convertirse en una herramienta concreta para cerrar uno de los principales
vacíos de seguridad del transporte privado y contribuir a una movilidad más segura y
confiable para las mujeres cruceñas.
1.1. Antecedentes
La preocupación por la seguridad de las mujeres en el transporte urbano no
es un fenómeno reciente ni exclusivo de Bolivia. A lo largo de las últimas
décadas, distintos países han reconocido esta problemática e impulsado
iniciativas de movilidad orientadas específicamente a mujeres. El análisis de
estas experiencias resulta relevante para el presente proyecto por una razón
concreta: todas ellas dependen, de forma explícita o implícita, de poder
garantizar que las personas que participan en el servicio conductoras y
pasajeras son realmente quienes dicen ser. Revisar cómo han abordado, o
dejado de abordar, la verificación de identidad permite situar con precisión el
aporte de este proyecto.
1.1.1. Antecedentes internacionales
A nivel internacional, uno de los antecedentes más representativos se
encuentra en la India, país donde la elevada incidencia de violencia
contra la mujer en el transporte público y privado motivó el
surgimiento de servicios de movilidad exclusivos para mujeres. El
caso más emblemático es el de She Taxi, una flota de taxis operada
exclusivamente por mujeres y destinada al transporte de pasajeras. El
servicio fue lanzado el 19 de noviembre de 2013 en
Thiruvananthapuram, en el estado de Kerala, como una iniciativa del
Gender Park, una institución autónoma promovida por el
Departamento de Justicia Social del Gobierno de Kerala (Government
of Kerala, 2013). El proyecto fue relanzado el 11 de mayo de 2020
con un alcance ampliado, extendiendo su servicio a los 14 distritos de
Kerala y obteniendo reconocimientos internacionales como una
mención especial del Banco Mundial en el South Asian Study Tour in
Gender in Transport.
A esta experiencia se sumaron otras iniciativas similares en distintas
ciudades de la India, como Sakha Cabs, Taxshe y She Cab
Hyderabad, todas ellas orientadas al transporte exclusivo de mujeres

por mujeres. Sakha Cabs, en colaboración con la Fundación Azad,
ofrece servicios de transporte exclusivamente para mujeres en las
ciudades de Jaipur, Delhi, Indore y Kolkata, capacitando a mujeres de
grupos marginados para convertirse en conductoras profesionales
(Women's Media Center, 2023). Estas iniciativas demostraron que
existe una demanda real y sostenida de servicios de transporte
exclusivos para mujeres y, al mismo tiempo, que estos modelos
pueden generar oportunidades concretas de empleo digno para
mujeres en situación de vulnerabilidad económica.
1.1.2. Antecedentes en América Latina
En el contexto latinoamericano, el antecedente más relevante es el de
Lady Driver, una plataforma de transporte privado exclusiva para
mujeres fundada en Brasil en 2017 por la emprendedora Gabryella
Corrêa. Lady Driver fue creada como respuesta directa a una
experiencia personal de acoso sufrida por su fundadora durante un
viaje contratado por una aplicación de transporte convencional, y se
ha convertido en el aplicativo de transporte femenino más grande del
mundo, según el diario británico Financial Times. En Brasil, la
aplicación acumula más de 10 millones de descargas y cuenta con
aproximadamente 105 mil conductoras registradas, con presencia en
49 ciudades brasileñas y operaciones también en el estado de
Maryland, en los Estados Unidos (Portal do Trânsito, 2024). Lady
Driver también incorpora un servicio especializado denominado Lady
Kiddos, destinado al transporte seguro de niños y adolescentes entre
los 8 y 16 años de edad.
En México, el antecedente más significativo es Laudrive, una
plataforma de transporte privado exclusiva para mujeres fundada por
el emprendedor Luis Fernando Montes de Oca y lanzada al mercado
el 1 de marzo de 2017 en la Ciudad de México. Laudrive surgió a
partir de la observación de que pocas mujeres se animaban a trabajar
como conductoras en plataformas convencionales como Uber o
Cabify debido a la sensación de inseguridad que les generaba
transportar a usuarios hombres (Excélsior, 2017). El servicio permite
el transporte exclusivo de mujeres y niños menores de 12 años, y
opera bajo un esquema en el que tanto las conductoras,
denominadas Laudys, como las pasajeras son únicamente del sexo
femenino (Milenio, 2017).

Laudrive demostró que un modelo de transporte exclusivo para
mujeres es viable comercialmente en América Latina y sentó un
precedente importante para iniciativas similares en otros países de la
región.
1.1.3. Antecedentes en Bolivia
En Bolivia, ya existen varias iniciativas que reflejan la creciente
necesidad de las mujeres de contar con servicios de transporte más
seguros y exclusivos, aunque ninguna de ellas opera bajo una
plataforma tecnológica formal con mecanismos avanzados de
verificación de identidad.
En la ciudad de Santa Cruz de la Sierra, la iniciativa más destacada
es Móvil Rosa, una línea de radio taxis conducida exclusivamente por
mujeres que brinda servicio las 24 horas del día. Móvil Rosa fue
fundada por Fabiola Gutiérrez como respuesta a los crecientes
hechos de inseguridad en el transporte urbano, donde las mujeres
figuran entre las víctimas más frecuentes, y prioriza la seguridad de
sus pasajeros mediante un seguimiento riguroso del recorrido (Red
Uno, 2024). El servicio funciona principalmente bajo un esquema de
solicitud telefónica, sin contar con una plataforma tecnológica que
integre verificación de identidad ni gestión digital de viajes en tiempo
real.
En La Paz, el referente más importante es Mujeres al Volante, un
emprendimiento fundado en abril de 2017 por la empresaria Gabriela
Strauss. Mujeres al Volante fue creada para ofrecer transporte seguro
a mujeres, niños y adultos mayores, en respuesta a los numerosos
casos de mujeres atacadas o secuestradas por taxistas, y empodera
a sus conductoras, en su mayoría madres solteras y mujeres mayores
de 45 años, ofreciéndoles oportunidades laborales flexibles
(LatinAmerican Post, 2024). Actualmente cuenta con
aproximadamente 35 conductoras y opera bajo solicitud por
WhatsApp, atendiendo de manera exclusiva a mujeres, niñas, niños y
personas de la tercera edad. Si bien la iniciativa proyecta el desarrollo
de una aplicación propia para expandirse a otras ciudades del país,
actualmente funciona sin una plataforma tecnológica estructurada.

En la ciudad de El Alto opera Línea Lila, una iniciativa enmarcada en
la Central de Mujeres Productivas y Emprendedoras de El Alto
(CEMUPE), que brinda servicios de transporte exclusivo para
mujeres, niños y adultos mayores.
Línea Lila fue creada tras un caso de feminicidio de alto perfil y
actualmente cuenta con 80 conductoras registradas, de las cuales
aproximadamente 20 prestan servicio diariamente, siendo la mayoría
sobrevivientes de violencia doméstica que utilizan este trabajo como
una vía para reconstruir sus vidas (LatinAmerican Post, 2024). En
Cochabamba existen también iniciativas similares como Taxi Lady y
Madame Taxi, ambas surgidas durante la pandemia del COVID-19, lo
que evidencia que la necesidad de transporte seguro para mujeres es
una problemática presente en todas las principales ciudades del país.
1.1.4. Antecedentes técnicos
Más allá del ámbito específico del transporte, la verificación automatizada de
identidad cuenta con antecedentes técnicos consolidados en otros sectores,
principalmente en la banca digital. Estos antecedentes son directamente
relevantes para el presente proyecto, ya que el sistema propuesto utiliza las
mismas tecnologías reconocimiento facial y reconocimiento óptico de
caracteres aplicadas al punto de registro de usuarios.
El procedimiento conocido como KYC (Electronic Know Your Customer) es
hoy el estándar de la incorporación remota de clientes en el sector financiero.
El proceso consta de varios pasos clave que a menudo se completan en
segundos gracias a la automatización: el cliente carga un documento de
identidad a través de un dispositivo móvil o aplicación web; tecnologías como
OCR autentican la validez del documento; el cliente envía una selfie que se
compara con la foto del documento mediante software de reconocimiento
facial; y el sistema verifica la presencia de una persona real. Esta última
comprobación, denominada prueba de vida, puede ser activa se orienta al
usuario a realizar determinados movimientos o pasiva, y sirve para impedir
que alguien burle el sistema usando una fotografía o un video.

La adopción de estas tecnologías responde a una necesidad concreta de
seguridad. Los casos denunciados de estafadores que utilizan identidades
robadas para abrir nuevas cuentas bancarias aumentaron un 32% en 2022,
lo que pone de relieve cómo las lagunas en la verificación pueden permitir
que se produzcan fraudes.
Por ello, la tecnología de verificación de documentos permite comprobar la
autenticidad de documentos como el documento de identidad o la licencia de
conducir en tiempo real, examinando características de seguridad como
hologramas y marcas de agua para prevenir el fraude.
Este tipo de soluciones ya opera en el contexto boliviano. Existen
plataformas que aplican algoritmos de inteligencia artificial capaces de validar
los principales documentos de identidad bolivianos incluyendo la Cédula de
Identidad, el pasaporte y la licencia de conducir, detectando inconsistencias y
extrayendo información, así como pruebas de vida que garantizan que quien
se identifica es realmente quien dice ser. Estos desarrollos se enmarcan en
un marco regulatorio que evoluciona para prevenir el lavado de activos
mediante normas como la Ley N° 393 de Servicios Financieros, lo que
confirma que la verificación de identidad basada en IA es viable y legalmente
pertinente en Bolivia.
1.2. Planteamiento del problema
El registro de usuarios constituye la primera barrera de seguridad de
cualquier sistema de transporte privado, pero en el mercado boliviano esa
barrera funciona sobre datos declarados que no se contrastan ni con un
documento de identidad oficial ni con el rostro de la persona que se inscribe.
Las plataformas que operan en Santa Cruz de la Sierra Uber, InDrive y Yango
habilitan el alta de conductores y pasajeros sin un proceso efectivo de
validación de identidad, lo que abre la puerta a la suplantación y compromete
la trazabilidad de cualquier incidente posterior. Esta debilidad estructural en
el punto de entrada al servicio convierte al registro en el principal punto
vulnerable de la cadena de seguridad de las plataformas locales.
Esta deficiencia adquiere una gravedad particular en el contexto cruceño.
Santa Cruz se consolidó en el Censo 2024 como el departamento más
poblado de Bolivia, con 3.122.605 habitantes y más de 1,6 millones

concentrados en el municipio capital (Instituto Nacional de Estadística [INE],
2025), lo que genera una elevada demanda de servicios de transporte
privado. Sobre esa demanda recae, además, un escenario de violencia de
género acentuado: en Santa Cruz de la Sierra siete de cada diez mujeres
sufren violencia en el transporte público con frecuencia diaria o semanal
(Ameller y Sandoval, 2022) y el departamento se posiciona consistentemente
entre los tres con mayor número de denuncias por violencia de género del
país (Observatorio Boliviano de Seguridad Ciudadana, 2025). En este
escenario, una plataforma que no puede garantizar la identidad real de sus
conductores deja de ser una herramienta de movilidad para convertirse en un
canal de exposición al riesgo.
La forma en que actualmente se intenta resolver este problema agrava la
situación en lugar de mitigarla. En las iniciativas locales de transporte para
mujeres Móvil Rosa en Santa Cruz, Mujeres al Volante en La Paz y Línea Lila
en El Alto la revisión de la documentación de las conductoras se realiza de
manera manual, dependiente del criterio visual de una persona. Este
procedimiento es lento, difícil de escalar y expuesto al error humano: una
fotografía alterada, un dato inconsistente o un documento adulterado pueden
pasar desapercibidos para quien revisa sin herramientas de validación.
Tampoco existe un mecanismo automatizado que, en el momento del
registro, contraste el rostro de la persona con la fotografía de su cédula y
confirme que el documento presentado es legítimo.
A esta carencia se suma un contraste tecnológico relevante. El
reconocimiento facial y el reconocimiento óptico de caracteres son
tecnologías maduras y ya se aplican con éxito sobre documentos de
identidad bolivianos en sectores de alta exigencia como la banca digital,
donde respaldan procesos de incorporación remota de clientes bajo modelos
eKYC enmarcados en la Ley N° 393 de Servicios Financieros. Existe, por
tanto, una solución técnicamente viable y legalmente pertinente que el sector
del transporte privado no ha adoptado, lo que mantiene abierta una brecha
entre la tecnología disponible y el sector que más la necesita.
Ante esta realidad, se identifica la necesidad de desarrollar un sistema de
validación administrativa de identidad y documentación que opere
específicamente en la etapa de registro de los servicios de transporte
privado, que verifique de manera automatizada el rostro y la cédula de

conductoras y pasajeras, y que cuente con un mecanismo de revisión
administrativa para los casos en que la verificación automatizada presente
dudas. El sistema se valida tomando como caso de estudio la propuesta de
iniciativa Lady's On Go en la zona del cuarto anillo de Santa Cruz de la
Sierra.
1.3. Árbol de problemas
Ilustración 1: Árbol de problemas
Fuente Propia
Causas:
● Registro basado en identidad solo declarada, sin validación efectiva.
● Verificación documental manual, lenta y propensa al error humano.
● Tecnologías de verificación de identidad (reconocimiento facial y
OCR) no adoptadas en el sector del transporte privado.

Problema central: El registro de usuarios en los servicios de transporte
privado de Santa Cruz de la Sierra valida la identidad de conductoras y
clientes de forma poco confiable, lo que lo vuelve vulnerable a la
suplantación de identidad.
Efectos:
● Suplantación de identidad en conductoras y clientes, lo que permite el
ingreso al servicio de personas no confiables o con antecedentes.
● Documentos falsos o adulterados que no son detectados, lo que
genera la imposibilidad de atribuir responsabilidad ante un incidente.
● Inseguridad de las mujeres frente a personas no verificadas, lo que
deriva en desconfianza y en la limitación de su libertad de
movimiento.
1.4. Formulación del problema
¿De qué manera el desarrollo de un sistema de validación de identidad y
documentación basado en reconocimiento facial y OCR mejorará la
confiabilidad del proceso de registro de conductoras y pasajeras en los
servicios de transporte privado en la ciudad de Santa Cruz de la Sierra?
1.5. Problemas secundarios
● ¿Qué limitaciones presentan los procesos de registro y verificación de
identidad de los servicios de transporte actualmente disponibles en el
mercado local?
● ¿Qué parámetros de control deben identificarse en la cédula de identidad
para determinar si un documento es auténtico o ha sido adulterado?
● ¿Qué nivel de precisión y confiabilidad alcanza un sistema de verificación de
identidad basado en reconocimiento facial y OCR aplicado sobre cédulas de
identidad bolivianas?

1.6. Objetivos
1.6.1. Objetivo general
Desarrollar un sistema de validación de identidad y documentación,
basado en reconocimiento facial y OCR, que verifique de forma
automatizada la identidad de conductoras y pasajeras en el registro
de servicios de transporte privado, tomando como caso de estudio
Lady 's On Go.
1.6.2. Objetivos específicos
● Analizar los procesos actuales de registro y verificación de identidad
en el transporte local, identificando los parámetros de control de la
cédula de identidad boliviana y definiendo los requerimientos
funcionales y no funcionales del sistema.
● Diseñar la arquitectura del sistema y el modelo de base de datos,
aplicando criterios de normalización.
● Desarrollar el sistema integrando el reconocimiento facial, que
compara el rostro de la persona con la fotografía de su documento, y
la verificación documental por OCR, que extrae y valida los datos de
la cédula.
● Evaluar la precisión y el funcionamiento del sistema mediante
pruebas con usuarias potenciales, verificando que cumpla los criterios
de validación definidos.
● Documentar el sistema desarrollado y elaborar las recomendaciones
para su implementación y mantenimiento en la iniciativa Lady 's On
Go.

1.7. Justificaciones
1.7.1. Justificación Económica
Hoy las iniciativas de transporte que verifican identidad lo hacen a
mano: alguien revisa cédulas, compara fotos y controla datos uno por
uno. Es lento, no escala y aun así se le escapan documentos
adulterados, lo que deja un costo operativo permanente y pérdidas
cuando un caso fraudulento termina en un incidente. El sistema
reemplaza esa revisión por una validación automática que resuelve
cada registro en segundos, baja el costo por usuaria incorporada y
permite que el volumen de altas crezca sin que el costo crezca igual.
Para una iniciativa como Lady 's On Go, la verificación deja de ser un
cuello de botella cuando sube la demanda.
Más allá del ahorro, el verdadero valor económico del proyecto está
en la seguridad que ofrece, y esa seguridad es comercializable. Como
el sistema fue diseñado de forma modular e independiente de la
plataforma de viajes, puede ofrecerse a otras empresas de transporte
privado como un módulo de verificación de identidad que ellas
integran a su propio servicio, generando una fuente de ingresos por
licenciamiento o por uso. Al mismo tiempo, una plataforma que
garantiza que todas sus conductoras y pasajeras fueron verificadas
convierte la confianza en una ventaja competitiva: más usuarias
dispuestas a usar el servicio se traducen en mayor demanda y, por
tanto, en mayores ingresos.
1.7.2. Justificación Social
En Santa Cruz de la Sierra, el miedo a sufrir acoso o una agresión
durante un viaje no es abstracto: condiciona los horarios en que las
mujeres se mueven, las rutas que toman y, en el fondo, su acceso al
trabajo, al estudio y a la vida social. Buena parte de ese miedo nace
de un hecho simple: al subir a un vehículo solicitado por aplicación, la
pasajera no tiene forma de saber si quien conduce es realmente la
persona registrada. El sistema interviene justo ahí, porque verifica en
el momento del registro que el rostro de quien se inscribe coincide
con el de su cédula y que esa cédula es auténtica, de modo que
nadie queda habilitado en el servicio sin haber sido identificado.

El beneficio es directo para dos grupos. Para las pasajeras, saber que
toda conductora pasó por una verificación rigurosa reduce la
exposición al riesgo y devuelve algo tan básico como moverse por la
ciudad sin tener que calcular el peligro. Para las conductoras, un
entorno donde también las usuarias están verificadas hace del
transporte una opción de trabajo más segura, sobre todo para
mujeres que buscan un ingreso sin exponerse. En conjunto, el
proyecto aporta a la meta del Objetivo de Desarrollo Sostenible 5
(ODS 5) de eliminar la violencia contra las mujeres en los espacios
públicos y privados, usando la tecnología como una herramienta
concreta de seguridad y no como un fin en sí mismo.
1.7.3. Justificación Técnica
Desde el punto de vista técnico, el proyecto se justifica por la
aplicación de tecnologías maduras y verificables a un problema
concreto de seguridad. El sistema integra reconocimiento facial
mediante redes neuronales convolucionales específicamente el
modelo ArcFace embebido en la librería DeepFace y reconocimiento
óptico de caracteres sobre cédulas de identidad bolivianas,
herramientas que representan el estado del arte en verificación de
identidad digital.
Estas tecnologías ya han demostrado su eficacia en sectores de alta
exigencia como la banca digital, donde respaldan procesos eKYC
sobre documentos de identidad bolivianos al amparo de la Ley N° 393
de Servicios Financieros. Su adaptación al sector del transporte
privado, sin embargo, no se ha producido. El sistema propuesto cubre
esa brecha mediante una arquitectura de dos capas: una aplicación
web construida sobre Laravel y MySQL, que gestiona el registro y la
base de datos; y un servicio de inteligencia artificial construido sobre
Python y FastAPI, que ejecuta la verificación facial y el OCR. Esta
separación permite que cada componente se desarrolle, pruebe y
actualice de manera independiente, y que el módulo de validación
pueda integrarse a otras plataformas en el futuro.

1.7.4. Justificación Metodológica
En lo metodológico, el proyecto articula métodos y técnicas propias
de la Ingeniería de Sistemas para responder a un problema real. La
investigación usa un enfoque mixto: encuestas estructuradas
aplicadas a mujeres mayores de 18 años residentes en la zona del
cuarto anillo, permite obtener datos representativos sobre el nivel de
aceptación y la valoración de un proceso de registro verificad, que
dan datos medibles sobre percepción de inseguridad y aceptación de
un registro verificado, y la consulta a expertos en el área tecnológica,
que valida desde afuera las decisiones de diseño y de selección de
tecnologías. Así, los requerimientos no salen de supuestos sino de
información de campo.
El desarrollo se gestiona con Scrum, que organiza el trabajo en
sprints cortos con entregas funcionales al cierre de cada uno; esto se
ajusta a un sistema con componentes de IA, cuya precisión solo se
confirma probando de forma iterativa con datos reales. A Scrum se
suman prácticas de Extreme Programming (XP) por una razón
puntual: la calidad del código. En un sistema donde un error de
validación de identidad compromete la seguridad de las usuarias, las
pruebas continuas, la integración frecuente y la simplicidad en el
diseño que aporta XP no son opcionales. Scrum ordena qué se
construye y en qué orden; XP asegura que lo construido sea
confiable.

1.8. Delimitación
1.8.1. Delimitación temporal
El proyecto se desarrolló durante el primer semestre de la gestión
2026, en el período comprendido entre febrero y junio. En ese lapso
se cubrieron todas las etapas: el diagnóstico de la situación actual
mediante encuestas y consulta a expertos, la definición de
requerimientos, la identificación de los parámetros de control de la
cédula de identidad, el diseño y desarrollo de los módulos de
reconocimiento facial y verificación documental, y las pruebas de
funcionamiento.
1.8.2. Delimitación Espacial
La investigación y el desarrollo del proyecto se llevarán a cabo en la
ciudad de Santa Cruz de la Sierra, Bolivia, específicamente en la
zona comprendida dentro del cuarto anillo de la ciudad. Esta área ha
sido seleccionada como zona de estudio porque concentra una alta
densidad poblacional, una intensa actividad comercial, educativa y
residencial, y una demanda significativa de servicios de transporte
privado urbano, lo que la convierte en el escenario más representativo
para llevar a cabo la investigación de campo y validar el sistema
desarrollado tomando como caso de estudio la iniciativa Lady's On
Go.
1.8.3. Delimitación Temática
El presente proyecto se enmarca dentro del área de la Ingeniería de
Sistemas, específicamente en las subáreas de inteligencia artificial
aplicada al reconocimiento facial y de patrones, verificación de
identidad digital, reconocimiento óptico de caracteres, seguridad
informática y gestión de bases de datos relacionales. El estudio se
centra exclusivamente en el desarrollo de un sistema de validación de
identidad y documentación para el registro de usuarios conductoras y
clientes en sistemas de transporte urbano.
El alcance del proyecto se limita a la fase de registro y verificación de
identidad de mujeres, tanto conductoras como pasajeras En
consecuencia, no contempla el desarrollo de las funciones operativas

de gestión de viajes, tales como la solicitud de viajes, la asignación de
conductoras, el seguimiento del trayecto, el sistema de calificaciones
o la gestión de pagos, las cuales corresponden a etapas posteriores
de desarrollo. Tampoco contempla el desarrollo de una aplicación
móvil nativa ni la implementación de seguimiento GPS en tiempo real.
El sistema está orientado a la verificación de usuarias de género
femenino, tanto en el rol de pasajeras como de conductoras, en
coherencia con el carácter del caso de estudio.
1.9. Metodología
1.9.1. Tipo de investigación
La investigación es de tipo aplicada, porque parte de un problema real
y concreto la falta de un mecanismo confiable de validación de
identidad en el registro de usuarias del transporte privado y propone
una solución tecnológica para resolverlo, no sólo describirlo.
Por su nivel de profundidad es descriptiva, ya que primero caracteriza
la situación actual de los procesos de registro y verificación de
identidad en Santa Cruz de la Sierra, identificando sus limitaciones y
las necesidades de seguridad de las usuarias; esa caracterización es
la base sobre la que se definen los requerimientos y las decisiones de
diseño.
El enfoque es mixto. La parte cuantitativa, mediante encuestas, mide
la percepción de inseguridad y la valoración de un registro verificado;
la parte cualitativa, mediante la consulta a expertos en el área
tecnológica, profundiza en las necesidades y aporta una fuente
calificada para validar las decisiones de diseño y desarrollo del
sistema.

1.10. Métodos y Técnicas
1.10.1. Encuesta estructurada
Se aplicó a mujeres mayores de 18 años residentes en la zona del
cuarto anillo de Santa Cruz de la Sierra. La encuesta incluyó
preguntas cerradas con escalas de valoración para medir la
percepción de inseguridad, la frecuencia de uso de servicios de
transporte privado y la valoración de un proceso de registro con
verificación de identidad. Sus resultados sustentan la definición de los
requerimientos del sistema.
1.10.2. Consulta a experta
Se consultó a una desarrolladora de software externa a la
universidad, con experiencia en el área tecnológica, a quien se
conoció en el espacio de innovación Fab Lab. La consulta se realizó
de manera informal, a modo de conversación, solicitando su opinión
sobre las decisiones técnicas del proyecto: la selección de
tecnologías para el reconocimiento facial y el OCR, el diseño del flujo
de validación híbrida y la viabilidad de separar el sistema en una capa
web y un servicio de inteligencia artificial. Sus observaciones sirvieron
como una mirada técnica externa que complementó los datos
obtenidos en la encuesta y ayudó a ajustar criterios de diseño antes
de la etapa de desarrollo.
1.11. Metodología de Desarrollo
El sistema se desarrolló con la metodología ágil Scrum, apoyada en prácticas
de Extreme Programming (XP). Scrum se eligió porque su trabajo iterativo se
ajusta a un sistema con componentes de inteligencia artificial, cuya precisión
solo se confirma probando con datos reales y no con una planificación
cerrada al inicio.
Según Pressman, Scrum organiza el desarrollo en sprints, ciclos de dos a
cuatro semanas al final de los cuales se entrega un avance funcional y
probado; así el producto se construye por partes, los errores se detectan
temprano y cada etapa se ajusta según lo obtenido en la anterior. Define tres
roles: el Product Owner, que prioriza las funcionalidades; el Scrum Master,

que facilita el proceso; y el Equipo de Desarrollo, que diseña, programa y
prueba el sistema.
XP se incorpora por la calidad del código. En un sistema donde un error de
validación de identidad compromete la seguridad de las usuarias, sus
prácticas pruebas continuas, integración frecuente y simplicidad en el diseño
resultan necesarias. Scrum ordena qué se construye y en qué orden; XP
asegura que lo construido sea confiable.

Capítulo II. Marco Teórico

1. Marco Teórico
2. Marco Teórico
El presente capítulo tiene como propósito establecer las bases conceptuales y
teóricas que sustentan el desarrollo del sistema de validación de identidad y
documentación. Para ello, se presentan y definen los principales conceptos,
tecnologías y metodologías que forman parte del proyecto, respaldados por autores
reconocidos en cada área del conocimiento. Comprender estos fundamentos es
esencial para entender las decisiones técnicas tomadas a lo largo del desarrollo del
sistema.
2.1. Sistema
Bertalanffy (1989) define un sistema como un conjunto de elementos
interrelacionados que funcionan de manera conjunta para alcanzar un
objetivo común, donde el resultado del trabajo coordinado supera a la suma
de las partes por separado. En su forma más básica, todo sistema tiene una
entrada que recibe información o recursos, un proceso que los transforma,
una salida que entrega un resultado y, por lo general, una retroalimentación
que le permite ajustarse.
Ese es justamente el objeto de este proyecto: un sistema de validación
administrativa que recibe como entrada el rostro de la persona y la imagen
de su cédula, ejecuta sobre ellos la verificación facial y la validación
documental, y entrega como salida un veredicto registro aprobado,
rechazado o derivado a revisión administrativa.
Ilustración 2: Elementos básicos de un sistema
Fuente Daniel Serra Sánchez

2.2. Sistema Web
Un sistema web, o aplicación web, es un programa al que se accede desde
un navegador sin instalar nada en el dispositivo. Pressman (2010) señala que
operan bajo una arquitectura cliente-servidor: la usuaria interactúa desde su
equipo y la lógica del sistema, junto con los datos, se procesa y almacena en
un servidor remoto. La ventaja de este modelo es que el mantenimiento, las
actualizaciones y la seguridad se concentran en el servidor, sin depender de
la versión instalada en cada equipo.
El proyecto se construye como sistema web por dos razones concretas: que
el registro y la verificación puedan hacerse desde cualquier dispositivo con
internet, y que la información sensible fotografías, cédulas y embeddings
faciales quede centralizada en un único servidor con controles de seguridad
uniformes.
Ilustración 3: Modelo Cliente-Servidor
Fuente Aitor Medrano

2.3. API Rest
Una API (Interfaz de Programación de Aplicaciones) es un conjunto de reglas
que permite que dos programas se comuniquen e intercambien información
de forma ordenada. Cuando esa comunicación se apoya en el protocolo
HTTP y sigue ciertos principios de diseño, se llama API REST
(Representational State Transfer), estilo arquitectónico definido por Fielding
(2000), el cliente solicita o envía datos al servidor mediante operaciones
estándar y recibe la respuesta en un formato estructurado, normalmente
JSON.
En este proyecto la API REST es lo que conecta los dos servidores del
sistema. La aplicación web envía las imágenes del rostro y del documento al
servicio de inteligencia artificial mediante una petición, y este devuelve el
resultado de la verificación. Gracias a esa comunicación estandarizada,
ambos componentes escritos en tecnologías distintas trabajan de forma
coordinada.
Ilustración 4: Modelo API REST
Fuente: iDempiere

2.4. Frontend
El frontend, o capa de presentación, es la parte de la aplicación con la que la
usuaria interactúa directamente desde el navegador: formularios, botones,
menús y, en general, todo lo que ve y manipula. Para Sommerville (2011), su
objetivo es traducir las funciones del sistema en una experiencia visual clara,
sin importar el nivel técnico de quien la use. Sus tecnologías base son HTML
para la estructura, CSS para la presentación y JavaScript para el
comportamiento dinámico.
Aquí el frontend son las pantallas del registro: el formulario de datos
personales, la captura de la cédula, la captura facial en vivo y la pantalla de
resultado. Todas se construyen con el motor de plantillas Blade de Laravel.
Ilustración 5: Arquitectura Fronted
Fuente: Henrique Marques Fernandes

2.5. Backend
Si el frontend es lo que se ve, el backend es lo que hace funcionar al sistema
por detrás. Es la parte que corre en el servidor y que la usuaria no ve, pero
que, como describe Sommerville (2011), procesa las solicitudes que llegan
del frontend, aplica las reglas del negocio, gestiona la seguridad y se
comunica con la base de datos para guardar o recuperar información.
En este proyecto el backend tiene un rol crítico: recibe las imágenes que
envía la usuaria, coordina la comunicación con el servicio de inteligencia
artificial, interpreta el resultado de la verificación, controla los permisos de
acceso y mantiene la integridad de la información almacenada.
Ilustración 6: Componentes del Backend
Fuente Marsiholo
2.6. Modelo Vista Controlador (MVC)
El MVC es un patrón de arquitectura muy usado en el desarrollo web que
organiza el código en tres partes con responsabilidades separadas. Según
Pressman (2010), el Modelo gestiona los datos y la lógica del negocio, la
Vista presenta la información a la usuaria y el Controlador actúa como
intermediario entre ambos, coordinando el flujo. Esta separación facilita el
mantenimiento y permite agregar funcionalidades sin desordenar el resto.

En la aplicación web del proyecto, los datos de las usuarias y los registros se
manejan desde los Modelos, las pantallas se arman desde las Vistas, y la
lógica que coordina la verificación se ejecuta desde los Controladores.
Ilustración 7: Patrón Modelo Vista Controlador (MVC)
Fuente: Precognis
2.7. Inteligencia Artificial
La inteligencia artificial (IA) es la rama de la informática dedicada a construir
sistemas capaces de ejecutar tareas que antes requerían capacidades
humanas, como aprender, razonar, reconocer imágenes o tomar decisiones.
Russell y Norvig (2021) la definen, en términos formales, como el estudio de
los agentes que perciben información de su entorno y actúan para alcanzar
objetivos determinados. De ella se desprenden varios campos de aprendizaje
automático, aprendizaje profundo, procesamiento del lenguaje natural, visión
por computadora cada uno orientado a un tipo de problema.
En este proyecto la IA es el componente central: tanto el reconocimiento
facial como la lectura del documento se apoyan en modelos de aprendizaje
profundo y visión por computadora, y son los que permiten que la verificación
de identidad se haga de forma automática y no manual.

2.8. Aprendizaje Automático (Machine Learning)
El aprendizaje automático es la rama de la IA que permite a un sistema
mejorar en una tarea a partir de los datos, sin que un programador le escriba
una regla para cada caso. Mitchell (1997) lo resume en una idea: un sistema
aprende cuando su rendimiento en una tarea mejora con la experiencia
acumulada. En la práctica esto ocurre en dos fases: durante el entrenamiento
el sistema procesa datos etiquetados y ajusta sus parámetros hasta reducir
el error; durante la inferencia aplica lo aprendido sobre datos nuevos para
producir un resultado.
Sobre esta base se sostienen los modelos de reconocimiento facial que usa
el proyecto, cuyos parámetros fueron entrenados previamente sobre grandes
conjuntos de imágenes de rostros y se reutilizan como modelos
pre-entrenados.
2.9. Aprendizaje Profundo (Deep Learning)
El aprendizaje profundo es una rama del aprendizaje automático que utiliza
redes neuronales artificiales organizadas en muchas capas para aprender
representaciones cada vez más complejas de los datos. Lo que lo distingue,
según Goodfellow, Bengio y Courville (2016), es que aprende de forma
jerárquica: las primeras capas detectan características simples y las
siguientes las combinan para reconocer estructuras más elaboradas, sin que
nadie tenga que definir manualmente qué buscar. En reconocimiento facial
esto se traduce en capas iniciales que captan bordes y contrastes, capas
intermedias que identifican ojos, nariz o boca, y capas finales que integran
todo para reconocer un rostro como una identidad única.
Esa capacidad de aprender por niveles es lo que lo volvió superior a las
técnicas anteriores en visión por computadora, y es la tecnología sobre la
que se apoyan los modelos que comparan el rostro de la persona con la foto
de su documento.

2.10. Redes Neuronales Convolucionales (CNN)
Las redes neuronales convolucionales (CNN) son un tipo de red de
aprendizaje profundo pensado específicamente para imágenes. Goodfellow,
Bengio y Courville (2016) explican que aplican sobre la imagen una
operación llamada convolución: recorren la imagen con pequeños filtros que
detectan características locales bordes, texturas, formas y, capa tras capa,
construyen representaciones cada vez más abstractas. Gracias a
propiedades como el uso compartido de pesos y cierta tolerancia a la
posición del objeto, una CNN puede reconocer un rostro aunque cambien su
ubicación, su iluminación o su escala dentro de la foto.
En el proyecto, las CNN son la arquitectura que está por debajo tanto del
modelo ArcFace de reconocimiento facial como de los modelos aplicados al
documento: en ambos casos, la red convierte una imagen en una
representación numérica que el sistema puede comparar y validar.
Ilustración 8: Arquitectura de Redes Neuronales Convolucionales
Fuente Juliensuze Liora

2.11. Visión por Computadora
La visión por computadora es el campo de la IA dedicado a que un sistema
extraiga información útil de imágenes y videos. Szeliski (2022) la asocia a
tareas como la detección de objetos, el reconocimiento de rostros, la lectura
de texto en imágenes o el análisis de escenas, y la describe como uno de los
campos de la IA con más aplicaciones ya consolidadas en producción.
En este proyecto engloba las dos tareas centrales del sistema: detectar y
analizar el rostro de la persona tanto en la captura en vivo como en la foto de
la cédula, y procesar la imagen del documento para localizar las zonas de
texto antes del OCR. La librería OpenCV es la herramienta principal con la
que se ejecutan estas tareas dentro del servicio de inteligencia artificial.
Ilustración 9: Visión por Computadora
Fuente Universidad Carlos III de Madrid

2.12. Reconocimiento de Patrones
El reconocimiento de patrones es la disciplina de la IA que se ocupa de
identificar regularidades y formas repetitivas dentro de grandes volúmenes de
información, sea en imágenes, sonidos, textos o datos numéricos. Bishop
(2006) señala que es lo que permite a un sistema clasificar información
nueva a partir de las características aprendidas de ejemplos previos, y la
considera una de las habilidades más fundamentales de la IA moderna. Es
algo que las personas hacen sin pensar reconocer un rostro entre la multitud
o una voz conocida y que los sistemas replican cuando se los entrena con
suficientes ejemplos.
En el proyecto, este es el principio que permite analizar tanto los rasgos del
rostro como la estructura de un documento, comparándolos con patrones
aprendidos para confirmar que lo presentado es auténtico.
Ilustración 10: Interfaz de Reconocimiento Facial
Fuente TECNO seguro

2.13. Biometría
La biometría es la ciencia que utiliza las características físicas o de
comportamiento únicas de cada persona para verificar su identidad de forma
automática. Jain, Ross y Nandakumar (2011) las dividen en dos grupos: las
fisiológicas, como la huella dactilar, el rostro, el iris o la geometría de la
mano; y las conductuales, como la firma, la forma de caminar o el ritmo de
tipeo. Su valor como mecanismo de seguridad está en que esos rasgos son
únicos, intransferibles y difíciles de falsificar: a diferencia de una contraseña,
que se olvida o se comparte, o de un documento, que se roba o se adultera,
los rasgos biométricos acompañan a la persona y se mantienen estables en
el tiempo.
Por eso la biometría se ha vuelto el estándar de autenticación en sectores
donde la seguridad es crítica, como el bancario, el migratorio y el
gubernamental, y es la base sobre la que este proyecto construye la
verificación de identidad.
Ilustración 11: Tipos de Biometría
Fuente Academia Pragma

2.14. Reconocimiento Facial
El reconocimiento facial es una tecnología biométrica que identifica o verifica
a una persona analizando los rasgos únicos de su rostro. Jain, Ross y
Nandakumar (2011) describen el proceso en tres etapas: la detección, en la
que el sistema localiza el rostro dentro de una imagen; la extracción de
características, donde mide la distancia entre los ojos, la forma de la nariz, el
contorno de la mandíbula y otros puntos para crear una representación
matemática única el vector facial o embedding; y la comparación, donde
contrasta esa representación con otra para determinar si corresponde a la
misma persona.
Presente hoy en la banca digital, los aeropuertos y el desbloqueo de
teléfonos, en este proyecto cumple un rol central durante el registro: es el
mecanismo que confirma que el rostro de quien se inscribe coincide con la
fotografía de su cédula, lo que cierra la puerta a que alguien se registre con
un documento ajeno.
Ilustración 12: Proceso de Extracción de Características Faciales
Fuente School of Control Science and Engineering, Shandong
University, Jinan 250061, China

2.15. Verificación Facial 1:1 e Identificación Facial 1:N
Dentro del reconocimiento facial conviene separar dos modalidades, porque
resuelven problemas distintos. La verificación, o comparación 1:1, responde
a la pregunta "¿esta persona es quien dice ser?": compara un rostro contra
una única referencia y confirma o rechaza la coincidencia. La identificación, o
comparación 1:N (uno a muchos), responde a "¿quién es esta persona?":
compara un rostro contra una base completa de rostros para encontrar a
quién pertenece. Jain, Ross y Nandakumar (2011) advierten que la 1:N es
mucho más costosa en cómputo y se reserva para contextos como la
investigación criminal, mientras que la 1:1 es más rápida y la adecuada para
autenticar.
El sistema usa exclusivamente verificación 1:1, ya que su objetivo no es
averiguar la identidad de un desconocido, sino confirmar que el rostro
capturado en vivo corresponde a la foto del documento presentado. Dejar
esto explícito delimita el alcance técnico del proyecto.
Ilustración 13: Verificación de Identidad y Seguridad
Fuente ARATEK

2.16. Suplantación de Identidad y Spoofing
La suplantación de identidad es el acto de hacerse pasar por otra persona
usando datos, documentos o rasgos ajenos para obtener un beneficio o
acceder a un servicio de forma fraudulenta. En los sistemas biométricos, este
fraude tiene un nombre propio: spoofing, que según Marcel, Nixon y Li (2019)
consiste en usar elementos falsos una fotografía impresa, un video en una
pantalla, una máscara para engañar al sistema y hacerle creer que tiene
enfrente a una persona legítima, como cuando alguien sostiene la foto de
otra persona frente a la cámara.
La suplantación es precisamente el problema que el proyecto busca prevenir:
las plataformas de transporte que no verifican con rigor permiten registrarse
con datos o documentos ajenos. El sistema la combate en dos frentes: la
verificación facial confirma que la persona corresponde a su documento, y la
detección de vida impide que ese control sea burlado con técnicas de
spoofing.
2.17. Verificación Documental
La verificación documental es el proceso que confirma la autenticidad y
validez de un documento de identidad una cédula, una licencia analizando de
forma automática sus características visuales, su estructura y la información
que contiene. Jain, Ross y Nandakumar (2011) la presentan como el
complemento de la verificación biométrica dentro de los sistemas modernos
de identidad: mientras el reconocimiento facial confirma que la persona es
real, la verificación documental confirma que el documento que presenta es
legítimo y le pertenece. En la práctica responde a tres preguntas sobre el
documento: si la información es coherente y tiene el formato esperado, si su
estructura corresponde a la de un documento auténtico, y si la foto que
aparece en él pertenece a quien lo presenta.
Este proyecto es el segundo pilar del sistema, junto al reconocimiento facial.
El alcance se concentra en validar la estructura y la consistencia de los datos
del documento, no en el análisis forense de elementos físicos de seguridad
como hologramas o tintas, que queda fuera de un sistema de este tipo.

2.18. Reconocimiento Óptico de Caracteres (OCR)
El Reconocimiento Óptico de Caracteres (OCR, por sus siglas en inglés) es
la tecnología que permite a un sistema "leer" automáticamente el texto
contenido en una imagen y convertirlo en datos digitales procesables. Mori,
Suen y Yamamoto (1992) describen su funcionamiento en cuatro etapas: el
preprocesamiento de la imagen para mejorar su calidad, la detección de las
zonas con texto, el reconocimiento de cada carácter y un posprocesamiento
que ordena y verifica la información obtenida.
En el sistema, cuando la usuaria sube la foto de su cédula, el OCR analiza la
imagen y extrae en formato estructurado los datos que interesan: el número
de cédula, el nombre completo, la fecha de nacimiento y la fecha de emisión.
Esos datos son los que luego pasan por los parámetros de control.
Ilustración 14: Flujo de Reconocimiento Óptico de Caracteres (OCR)
Fuente: OGNYTE

2.19. Parámetros de Control y Validación de Estructura Documental
Los parámetros de control son el conjunto de criterios y reglas con los que el
sistema decide si la información extraída de un documento es válida y
coherente con la estructura que ese documento debería tener. Una vez que
el OCR extrae el texto de la cédula, esos datos no se aceptan sin más:
deben pasar una serie de comprobaciones que confirman su consistencia. En
el caso de la cédula boliviana, algunos de esos controles son que el número
contenga solo dígitos y respete la cantidad de caracteres establecida; que las
fechas tengan un formato válido y sean coherentes entre sí la de nacimiento
anterior a la de emisión; que los campos obligatorios, como el nombre, no
estén vacíos; y que la disposición general de los datos corresponda a la de
una cédula real. Estas comprobaciones se implementan habitualmente con
expresiones regulares y reglas de validación.
Definir bien estos parámetros es una de las tareas centrales del proyecto,
porque son ellos los que permiten al sistema determinar de forma automática
si un documento es estructuralmente válido o si presenta inconsistencias que
lo vuelven sospechoso.
2.20. Cédula de Identidad Boliviana
La cédula de identidad es el documento oficial que acredita la identidad de
una persona en Bolivia. La emite el Servicio General de Identificación
Personal (SEGIP) y es el documento de referencia para cualquier verificación
de identidad en el país. Reúne un conjunto de datos personales
estructurados como número de cédula, nombre completo, fecha y lugar de
nacimiento, fecha de emisión y de vencimiento, además de la fotografía del
titular y su firma.
Conocer su estructura es indispensable para el proyecto, porque es el
documento sobre el que operan el OCR y la validación de estructura: el
sistema debe reconocer la disposición de sus campos, extraer cada dato y
aplicar los parámetros de control. Su fotografía, además, es la imagen de
referencia contra la que se compara el rostro capturado en vivo. Cabe
señalar que Bolivia renovó el diseño de la cédula en 2023, por lo que el
sistema contempla el formato vigente.

Ilustración 15: Cédula de identidad Boliviana (Anverso y Reverso)
Fuente ElSajama Prensa
2.21. eKYC (Electronic Know Your Customer)
El eKYC ("conozca electrónicamente a su cliente") es el procedimiento digital
con el que una organización verifica de forma remota y automatizada la
identidad de una persona antes de incorporar a un servicio. Nació en el
sector financiero, donde la normativa obliga a los bancos a confirmar la
identidad real de sus clientes, y hoy es el estándar de la incorporación digital
de usuarios. Su flujo es conocido: la persona carga su documento desde el
móvil o la web, el OCR valida el documento, una selfie se compara con la
foto mediante reconocimiento facial y el sistema confirma que se trata de una
persona real.

Como se ve, el eKYC integra exactamente los mismos componentes que
este proyecto verificación documental con OCR, reconocimiento facial y
detección de vida, y por eso es su antecedente conceptual directo: el sistema
toma un procedimiento ya consolidado en la banca digital y lo lleva al registro
de usuarias del transporte privado, un sector donde esta verificación todavía
no se aplica.
2.22. PHP y Laravel
PHP es un lenguaje de programación de código abierto pensado para el
desarrollo web del lado del servidor. Creado por Rasmus Lerdorf en 1994
(The PHP Group, 2023), es uno de los lenguajes más usados del mundo
para construir sitios y aplicaciones, y está detrás de plataformas como
Wikipedia y WordPress. Se ejecuta en el servidor: consulta y procesa la
información necesaria y genera la página que finalmente llega al navegador.
Laravel es un framework de desarrollo web escrito en PHP que aporta un
conjunto de herramientas, librerías y convenciones para construir
aplicaciones más rápido y con mejor orden. Otwell (2024), su creador, lo
lanzó en 2011 para que los desarrolladores no tuvieran que programar desde
cero las funciones comunes de toda aplicación. Trae listas funciones como la
autenticación de usuarios, el manejo de base de datos y la gestión de rutas,
todo bajo una estructura que sigue el patrón MVC. En este proyecto, Laravel
es el framework sobre el que se construye la aplicación web el servidor
encargado del registro, los paneles de usuaria y la base de datos, lo que
mantiene esa capa segura, organizada y mantenible.
2.23. Blade
Blade es el motor de plantillas oficial de Laravel, que permite crear páginas
dinámicas combinando HTML con instrucciones que generan contenido
personalizado. Otwell (2024) lo diseñó para ser simple e intuitivo, sin
sacrificar la potencia de PHP. A diferencia de una página estática, que
muestra siempre lo mismo, una vista en Blade puede adaptar su contenido
según quién la visite saludar a la usuaria por su nombre o mostrar opciones

distintas según su rol y permite reutilizar partes comunes, como menús o pies
de página, sin copiar el código en cada archivo.
En el proyecto, Blade construye las pantallas que ven las usuarias durante el
registro y la verificación, dándoles una apariencia coherente entre todas.
2.24. MySQL y Bases de Datos Relacionales
Una base de datos es un sistema para almacenar, gestionar y recuperar
información de forma ordenada. Entre los tipos existentes, las relacionales
son las más usadas: Date (2004) explica que organizan la información en
tablas de filas y columnas, donde cada tabla representa un tipo de entidad y
las tablas se vinculan mediante campos comunes, lo que evita duplicar datos
y mantiene la coherencia. MySQL es uno de los gestores de bases de datos
relacionales de código abierto más usados, reconocido por su rapidez,
estabilidad y compatibilidad con aplicaciones web.
En este proyecto, MySQL almacena toda la información del sistema: los
datos de las usuarias, los registros de las verificaciones y el resultado de
cada proceso. Su diseño aplica técnicas de normalización, que ordenan las
tablas para eliminar redundancias y proteger la integridad de los datos, algo
especialmente importante tratándose de información sensible.
2.25. Python y FastAPI
Python es un lenguaje de código abierto conocido por su sintaxis clara y su
versatilidad. Van Rossum y Drake (2009) destacan que fue diseñado
priorizando la legibilidad del código, lo que lo volvió uno de los lenguajes más
usados, sobre todo en inteligencia artificial, aprendizaje automático y visión
por computadora, donde se concentran las librerías más maduras. Esa es la
razón de fondo por la que el proyecto lo emplea para el componente de IA:
las herramientas de reconocimiento facial y OCR que el sistema necesita
están desarrolladas de forma nativa en él.
FastAPI es un framework de Python para construir API de forma rápida y
eficiente, que deja a un programa Python disponible como un servicio web
capaz de recibir solicitudes y devolver respuestas. En el proyecto cumple un
papel clave en la arquitectura: con él se construye el servicio de inteligencia
artificial como un servidor independiente, que expone mediante una API

REST las funciones de reconocimiento facial y verificación documental para
que la aplicación web en Laravel pueda solicitarlas.
2.26. OpenCV, DeepFace y Librerías de OCR
El componente de inteligencia artificial se arma con varias librerías de código
abierto, cada una a cargo de una tarea dentro del proceso de verificación.
OpenCV (Open Source Computer Vision Library) es una de las librerías de
visión por computadora más usadas; Bradski y Kaehler (2008) destacan su
amplio conjunto de funciones para procesar imágenes, y en el proyecto se
ocupa de las tareas iniciales: capturar la foto, mejorar su calidad y localizar el
rostro dentro de ella.
DeepFace es una librería de Python que implementa modelos de aprendizaje
profundo para reconocimiento facial y ofrece de forma sencilla la
comparación de rostros; es la que realiza la verificación 1:1, ya que una vez
que OpenCV localizó el rostro, DeepFace lo compara con la foto del
documento y determina si son la misma persona. Por último, librerías de
OCR como EasyOCR o Tesseract leen la cédula y extraen su texto,
convirtiéndo en datos que el sistema valida con los parámetros de control. La
combinación cubre las dos tareas centrales del sistema: verificar el rostro y
leer el documento usando exclusivamente tecnología de código abierto.
2.27. Seguridad Informática y la Triada CID
La seguridad informática es la disciplina que protege los sistemas, las redes
y los datos frente a accesos no autorizados, daños, alteraciones o
interrupciones. Stallings (2022) la describe como el conjunto de medidas
técnicas, organizativas y humanas orientadas a preservar tres propiedades
de la información, conocidas como la tríada CID: confidencialidad, integridad
y disponibilidad. La confidencialidad asegura que solo accedan a la
información las personas o procesos autorizados; la integridad garantiza que
los datos no se modifiquen de forma indebida o accidental, manteniéndose
exactos y completos; y la disponibilidad asegura que la información y los
servicios estén accesibles cuando se los necesite.

En este proyecto la seguridad no es opcional, sino un fundamento del diseño,
porque se manejan datos especialmente sensibles: fotografías de rostros,
imágenes de documentos e información personal. Las tres propiedades se
aplican de forma concreta: la confidencialidad, almacenando cifradas las
imágenes faciales y los documentos y restringiendo su acceso a los procesos
de verificación; la integridad, evitando que los datos extraídos del documento
y el resultado de la verificación se alteren entre la captura y el registro; y la
disponibilidad, manteniendo el proceso de registro estable cuando las
usuarias lo necesiten.
Ilustración 16: Triada CID de Seguridad de la Información
Fuente Hacker Mentor
2.28. Metodología Ágil
Una metodología de desarrollo es el conjunto de procedimientos, prácticas y
reglas con los que se organiza la construcción de un sistema. Las
metodologías ágiles surgieron como respuesta a las limitaciones de los
enfoques tradicionales, que organizaban el trabajo en etapas rígidas y
secuenciales. El Manifiesto Ágil (Beck et al., 2001), documento fundacional
de este enfoque, prioriza la entrega temprana y continua de software
funcional, la colaboración constante y la respuesta al cambio por encima de
la documentación exhaustiva y la planificación cerrada. En lugar de construir
todo el sistema antes de mostrarlo, lo ágil lo construye por partes y valida

cada una antes de seguir, lo que permite detectar errores a tiempo y corregir
el rumbo sin rehacer el trabajo.
En este proyecto el enfoque ágil resulta conveniente porque el sistema se
compone de módulos que pueden desarrollarse y probarse de forma
progresiva, validando cada componente reconocimiento facial, verificación
documental y aplicación web antes de avanzar al siguiente.
Ilustración 17: Ciclo de Metodologías Ágiles
Fuente British Digital
2.29. Scrum
Scrum es uno de los marcos de trabajo ágiles más usados en el desarrollo de
software. Schwaber y Sutherland (2020), autores de su guía oficial, lo
describen como un marco que organiza el desarrollo en ciclos cortos y
repetitivos llamados sprints, de dos a cuatro semanas, al final de los cuales
se entrega un avance funcional y verificable. Así el producto se construye de
forma progresiva, los errores se detectan temprano y cada ciclo se ajusta
según los resultados del anterior. Define tres roles: el Product Owner, que
define las funcionalidades y su prioridad; el Scrum Master, que facilita el
proceso y mantiene al equipo organizado; y el Equipo de Desarrollo, que
diseña, programa y prueba. El trabajo parte de una lista priorizada de tareas,
el product backlog, de la que se seleccionan los elementos de cada sprint.

En el proyecto, Scrum permite gestionar de forma ordenada el desarrollo de
los módulos, priorizando los componentes críticos de seguridad,
reconocimiento facial y verificación documental y entregando avances
probados al cierre de cada sprint.
Ilustración 18: Marco de Trabajo SPRINT (SCRUM)
Fuente USM Cloud Services
2.30. Extreme Programming (XP)
Extreme Programming (XP) es una metodología ágil centrada en la calidad
del código y en la entrega continua de funcionalidades probadas. Beck y
Andres (2004), sus creadores, la plantean como llevar al extremo un conjunto
de buenas prácticas de desarrollo, aplicándolas de forma constante durante
todo el proyecto para producir software robusto y fácil de mantener. Entre
esas prácticas están las pruebas continuas, que verifican cada porción de
código a medida que se escribe; la integración frecuente, que une y
comprueba los avances con regularidad para detectar incompatibilidades a
tiempo; y la simplicidad en el diseño, que implementa solo lo necesario para
resolver el problema. Donde Scrum aporta el marco para organizar el trabajo,
XP aporta las prácticas técnicas que aseguran la calidad de lo construido, y
por eso suelen usarse combinadas.

En el proyecto, las prácticas de XP pesan sobre todo en los módulos de
inteligencia artificial, donde probar de forma continua cada función de
reconocimiento facial y de validación documental es indispensable para
obtener resultados confiables.
2.31. Embedding Facial (Vector Facial)
Un embedding facial, o vector facial, es una representación matemática que
resume los rasgos únicos de un rostro en una lista ordenada de números.
Schroff, Kalenichenko y Philbin (2015), creadores del modelo FaceNet, lo
construyeron haciendo que una red neuronal aprenda a convertir cada rostro
en un vector de dimensión fija típicamente 128 o 512 números, de modo que
los vectores de una misma persona quedan cerca entre sí y los de personas
distintas, lejos. Así, en vez de comparar dos fotografías píxel por píxel, el
sistema convierte cada rostro en su vector y mide la distancia entre ambos; si
esa distancia es menor que un umbral definido, concluye que se trata de la
misma persona.
En el proyecto, el embedding sostiene toda la verificación facial: el rostro
capturado en vivo y la fotografía del documento se convierten cada uno en un
vector de 512 dimensiones, y la decisión de aceptar o rechazar el registro
depende de la distancia entre ambos frente a un umbral previamente
calibrado.
2.32. Validación Administrativa Híbrida
La validación administrativa híbrida combina la decisión automática de un
sistema basado en inteligencia artificial con la revisión manual de un
administrador cuando los resultados automáticos no son concluyentes.
Corresponde al principio de human-in-the-loop, adoptado en sistemas de
eKYC y en procesos críticos de identidad digital, donde la automatización
resuelve la mayoría de los casos pero se mantiene un canal de revisión
humana para los casos límite, buscando equilibrio entre eficiencia y
seguridad. Es lo que ocurre, por ejemplo, en la apertura remota de cuentas
bancarias: el sistema valida automáticamente la mayoría de los registros,
pero cuando la confianza es baja una foto borrosa, un rostro con cambios
respecto al documento la solicitud pasa a un operador que decide.

Esta es la lógica detrás de la palabra "administrativa" en el título del sistema:
la verificación se hace de forma automática con reconocimiento facial, OCR y
detección de vida, y solo cuando el resultado queda por debajo del umbral de
confianza el caso se deriva a un panel administrativo donde una persona
revisa la documentación y toma la decisión final, evitando que un registro
dudoso se apruebe sólo.
2.33. Marco Referencial
2.33.1. Lady´s On Go: Propuesta de iniciativa
Lady 's On Go es una propuesta de transporte privado exclusivo para
mujeres en Santa Cruz de la Sierra, concebida por Bianca Sthefania
Aguilar Durán en 2025. Surge como respuesta a la inseguridad que
enfrentan las mujeres cruceñas en los servicios de transporte privado
del mercado local, donde la falta de mecanismos efectivos de
verificación de identidad de conductores y pasajeros abre la puerta a
la suplantación y a situaciones de violencia de género.
La iniciativa tiene referentes que ya operan en el país: en Santa Cruz,
Móvil Rosa funciona como línea de radio taxis conducida solo por
mujeres; en La Paz, Mujeres al Volante ofrece transporte seguro a
mujeres, niños y adultos mayores; y en El Alto, Línea Lila opera bajo
el mismo principio dentro de la Central de Mujeres Productivas y
Emprendedoras. Estos casos muestran que existe una demanda real
y sostenida de transporte exclusivo para mujeres en Bolivia, pero
comparten una limitación: ninguno cuenta con una plataforma que
integre la verificación automatizada de identidad como control en el
momento del registro.
Es justamente ahí donde Lady 's On Go busca diferenciarse. Su
desarrollo completo como plataforma de transporte excede el alcance
temporal de este proyecto, pero su componente más crítico la
validación rigurosa de la identidad de conductoras y pasajeras al
registrarse sí se desarrolla en este trabajo. Lady 's On Go es,
entonces, el caso de estudio sobre el cual se diseña, implementa y
valida el sistema, sentando las bases tecnológicas para que la
iniciativa, más adelante, pueda expandirse a la gestión completa de
viajes.

2.33.2. Misión
Brindar a las mujeres de Santa Cruz de la Sierra un servicio de
transporte privado seguro y confiable, mediante una plataforma que
verifica rigurosamente la identidad de conductoras y pasajeras,
garantizando que cada viaje se realice exclusivamente entre mujeres
previamente validadas.
2.33.3. Visión
Consolidarse como la iniciativa de referencia en movilidad segura
para mujeres en Bolivia, demostrando que la verificación tecnológica
de identidad puede ser una herramienta concreta para reducir la
inseguridad de género en el transporte urbano.
2.33.4. Servicio Propuesto
Lady 's On Go propone un servicio de transporte privado dirigido
exclusivamente a mujeres, tanto en el rol de pasajeras como en el de
conductoras. Incorporarse al servicio, en cualquiera de los dos roles,
exige superar un proceso de validación que verifica la coincidencia
entre el rostro de la persona y la fotografía de su documento, además
de la autenticidad estructural del documento presentado. Solo las
usuarias cuyo registro fue validado pueden formar parte del servicio, y
ese es su elemento diferenciador frente a las plataformas
convencionales del mercado local.
2.33.5. Zona de operación
La iniciativa se proyecta para operar dentro del cuarto anillo de Santa
Cruz de la Sierra. Según el Censo de Población y Vivienda 2024, el
municipio de Santa Cruz supera los 1,6 millones de habitantes y es el
más poblado del país (INE, 2025). El área del cuarto anillo concentra
una alta densidad poblacional y una intensa actividad residencial,
comercial y educativa, lo que genera una demanda significativa de
transporte privado urbano y la vuelve un escenario representativo
para implementar y validar el sistema.

Capítulo III. Ingeniería del Proyecto
1.
2.

3. Ingeniería del Proyecto
En este capítulo se aborda el diseño y la especificación del sistema. Se parte de un
análisis que justifica el modelo adoptado y delimita su alcance; luego se documentan
los requisitos funcionales y no funcionales, las historias de usuario y los casos de
uso que definen la interacción con el sistema; y se cierra con el modelado y los
diagramas que representan su estructura lógica y física.
3.1. Análisis del proyecto
El sistema se diseñó bajo un enfoque modular y de dos capas
independientes: una aplicación web, encargada del registro y la persistencia
de los datos, y un servicio de inteligencia artificial, encargado de la
verificación facial y documental. Separar ambas capas responde a una
decisión concreta: permite desarrollar y probar por separado la parte web y la
parte de IA cuya precisión solo se confirma con pruebas iterativas y deja el
componente de validación listo para integrarse, más adelante, a otras
plataformas de transporte.
Sobre esa base, el sistema se organiza en seis módulos funcionales, cada
uno con una responsabilidad delimitada dentro del proceso de verificación:
● Registro de usuarias: gestiona el formulario con el que conductoras
y pasajeras ingresan sus datos y crean su cuenta. Es el punto de
entrada al proceso.
● Captura de imágenes: recibe la fotografía del documento y la
imagen facial capturada en vivo, validando formato y calidad mínima
antes de enviarlas a procesar.
● Reconocimiento facial: ejecuta la verificación 1:1 comparando el
rostro capturado con la foto del documento, generando un embedding
por imagen y midiendo la distancia entre ambos vectores.
● Verificación documental (OCR): extrae los datos de la cédula y les
aplica los parámetros de control para validar su estructura y
consistencia.
● Detección de vida (liveness): analiza la imagen facial para distinguir
entre una persona real frente a la cámara y un intento de suplantación
con fotografía, video o máscara.

● Validación administrativa: se activa cuando los módulos
automáticos arrojan un resultado por debajo del umbral de confianza,
derivando el caso a un panel donde un operador revisa la
documentación y decide.
Delimitación del alcance. El sistema cubre exclusivamente la etapa de
registro y verificación de identidad; quedan fuera las funciones de operación
del servicio solicitud y asignación de viajes, geolocalización, pagos y
calificaciones, previstas para una fase posterior. Asimismo, la verificación
documental se limita a la cédula de identidad boliviana en su formato vigente
y se centra en la validación estructural de los datos, no en el análisis forense
de elementos físicos de seguridad como hologramas o tintas.
3.2. Recolección de Requisitos
3.2.1. Requisitos Funcionales
Tabla 1: Requerimiento Funcional 1
Código de RNF01
requerimiento
Nombre del Registro de usuarias
requerimiento
Tipo de Requisito Funcional
requerimiento
Descripción del El sistema debe permitir el registro de conductoras y pasajeras
requerimiento mediante el ingreso de sus datos personales básicos y la carga
de la documentación requerida para iniciar el proceso de
validación de identidad.
Prioridad del Alta/Esencial Media/Deseado Baja/Opcional
requerimiento
Fuente: Elaboración Propia

Tabla 2: Requerimiento Funcional 2
| Código de  | RNF02  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Carga de documento de identidad  |     |     |
| ----------- | -------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir a la usuaria cargar imágenes del
requerimiento  anverso y reverso de su cédula de identidad para su posterior
análisis y validación.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 3: Requerimiento Funcional 3
| Código de  | RNF03  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Captura de fotografía facial  |     |     |
| ----------- | ----------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir la captura o carga de una fotografía
requerimiento  facial de la usuaria para realizar el proceso de comparación
biométrica con la imagen del documento de identidad.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 4: Requerimiento Funcional 4
| Código de  | RNF04  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Extracción de datos mediante OCR  |     |     |
| ----------- | --------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe extraer automáticamente la información textual
requerimiento  de la cédula de identidad utilizando tecnología OCR,
obteniendo datos como nombre completo, número de
documento, fecha de nacimiento y fecha de emisión.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 5: Requerimiento Funcional 5
| Código de  | RNF05  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Validación de estructura documental  |     |     |
| ----------- | ------------------------------------ | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe verificar que la información extraída del
requerimiento  documento cumpla con los formatos y parámetros de control
definidos para la cédula de identidad boliviana.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 6: Requerimiento Funcional 6
| Código de  | RNF06  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Comparación biométrica facial   |     |     |
| ----------- | ------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe comparar el rostro capturado de la usuaria con
requerimiento  la fotografía contenida en el documento de identidad para
determinar el nivel de coincidencia entre ambas imágenes.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 7: Requerimiento Funcional 7
| Código de  | RNF07  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Detección de prueba de vida  |     |     |
| ----------- | ---------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe verificar que la imagen facial provenga de una
requerimiento  persona real y no de una fotografía, video o intento de
suplantación de identidad.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 8: Requerimiento Funcional 8
Código de RNF08
requerimiento
Nombre del Determinación automática del resultado de validación
requerimiento
Tipo de Requisito Funcional
requerimiento
Descripción del El sistema debe generar automáticamente un resultado de
requerimiento validación indicando si la identidad fue aprobada, rechazada o
requiere revisión administrativa.
Prioridad del Alta/Esencial Media/Deseado Baja/Opcional
requerimiento
Fuente: Elaboración Propia
Tabla 9: Requerimiento Funcional 9
Código de RNF09
requerimiento
Nombre del Revisión administrativa de casos observados
requerimiento
Tipo de Requisito Funcional
requerimiento
Descripción del El sistema debe permitir que un administrador revise
requerimiento manualmente los registros cuya validación automática presente
inconsistencias o resultados ambiguos.
Prioridad del Alta/Esencial Media/Deseado Baja/Opcional
requerimiento
Fuente: Elaboración Propia

Tabla 10: Requerimiento Funcional 10
| Código de  | RNF10  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Gestión de estados de verificación  |     |     |
| ----------- | ----------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe almacenar y administrar los estados de cada
requerimiento  solicitud de registro, permitiendo identificar registros pendientes,
aprobados, rechazados y observados.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 11: Requerimiento Funcional 11
| Código de  | RNF11  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Consulta de historial de verificaciones   |     |     |
| ----------- | ----------------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir a los administradores consultar el
requerimiento  historial de validaciones realizadas, incluyendo fecha, resultado
y observaciones registradas.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 12: Requerimiento Funcional 12

| Código de  | RNF12  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Notificación del resultado de validación   |     |     |
| ----------- | ------------------------------------------ | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe notificar al usuario el resultado final del proceso
requerimiento  de validación de identidad, indicando si su registro fue
aprobado, rechazado o requiere información adicional.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 13: Requerimiento Funcional 13

| Código de  | RNF13  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Gestión de usuarios administradores   |     |     |
| ----------- | ------------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir la creación, modificación,
requerimiento  desactivación y consulta de cuentas de administradores
autorizados para la gestión de verificaciones.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 14: Requerimiento Funcional 14

| Código de  | RNF14  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Consulta de detalles de verificación   |     |     |
| ----------- | -------------------------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir visualizar el detalle completo de cada
requerimiento  proceso de validación, incluyendo imágenes, datos extraídos
por OCR y resultado de la comparación facial.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 15: Requerimiento Funcional 15

| Código de  | RNF15  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Búsqueda de registros   |     |     |
| ----------- | ----------------------- | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir buscar registros de usuarias mediante
requerimiento  filtros como nombre, número de documento, fecha de registro o
estado de validación.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 16: Requerimiento Funcional 16
| Código de  | RNF16  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Generación de reportes   |     |     |
| ----------- | ------------------------ | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe generar reportes de validaciones realizadas,
requerimiento  aprobadas, rechazadas y observadas en períodos de tiempo
determinados.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 17: Requerimiento Funcional 17
| Código de  | RNF17  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Reenvío de solicitud de validación   |     |     |
| ----------- | ------------------------------------ | --- | --- |
requerimiento
| Tipo de  | Requisito Funcional  |     |     |
| -------- | -------------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir a una usuaria volver a enviar
requerimiento  fotografías o documentación cuando su registro haya sido
observado o rechazado por inconsistencias corregibles.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

3.2.2. Requisitos No funcionales
Tabla 18: Requerimiento No Funcional 1
| Código de  | RNF01   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  |     |     |     |
| ----------- | --- | --- | --- |
requerimiento
Disponibilidad del sistema

| Tipo de  | Restricción   |     |     |
| -------- | ------------- | --- | --- |
requerimiento
Descripción del  El sistema debe estar disponible para las usuarias y
requerimiento  administradores las 24 horas del día, los 7 días de la semana,
garantizando una disponibilidad mínima del 95% anual.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 19: Requerimiento No Funcional 2
| Código de  | RNF02   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Tiempo de respuesta de validación   |     |     |
| ----------- | ----------------------------------- | --- | --- |
requerimiento
| Tipo de  | Rendimiento   |     |     |
| -------- | ------------- | --- | --- |
requerimiento
Descripción del  El sistema debe procesar y mostrar el resultado de una
requerimiento  validación de identidad en un tiempo máximo de 15 segundos
bajo condiciones normales de operación.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 20: Requerimiento No Funcional 3

| Código de  | RNF03   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Protección de datos personales   |     |     |
| ----------- | -------------------------------- | --- | --- |
requerimiento
| Tipo de  | Seguridad   |     |     |
| -------- | ----------- | --- | --- |
requerimiento
Descripción del  El sistema debe almacenar de forma segura las fotografías
requerimiento  faciales y documentos de identidad mediante mecanismos de
cifrado para proteger la información sensible de las usuarias.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 21: Requerimiento No Funcional 4
| Código de  | RNF04   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Comunicación segura   |     |     |
| ----------- | --------------------- | --- | --- |
requerimiento
| Tipo de  | Seguridad   |     |     |
| -------- | ----------- | --- | --- |
requerimiento
Descripción del  Toda comunicación entre el navegador, el servidor web y los
requerimiento  servicios de inteligencia artificial debe realizarse mediante
protocolos seguros HTTPS/TLS.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 22: Requerimiento No Funcional 5
| Código de  | RNF05   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Control de acceso   |     |     |
| ----------- | ------------------- | --- | --- |
requerimiento
| Tipo de  | Seguridad   |     |     |
| -------- | ----------- | --- | --- |
requerimiento
Descripción del  El sistema debe restringir el acceso a las funcionalidades
requerimiento  administrativas únicamente a usuarios autorizados mediante
autenticación y control de roles.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento
Fuente: Elaboración Propia

Tabla 23: Requerimiento No Funcional 6
| Código de  | RNF06   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Compatibilidad multiplataforma   |     |     |
| ----------- | -------------------------------- | --- | --- |
requerimiento
| Tipo de  | Compatibilidad   |     |     |
| -------- | ---------------- | --- | --- |
requerimiento
Descripción del  El sistema debe funcionar correctamente en los navegadores
requerimiento  Google Chrome, Mozilla Firefox, Microsoft Edge y Safari en sus
versiones vigentes.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 24: Requerimiento No Funcional 7

| Código de  | RNF07   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Diseño adaptable   |     |     |
| ----------- | ------------------ | --- | --- |
requerimiento
| Tipo de  | Usabilidad   |     |     |
| -------- | ------------ | --- | --- |
requerimiento
Descripción del  La interfaz del sistema debe adaptarse automáticamente a
requerimiento  dispositivos móviles, tabletas y computadoras de escritorio sin
pérdida de funcionalidad.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 25: Requerimiento No Funcional 8
| Código de  | RNF08   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Facilidad de uso   |     |     |
| ----------- | ------------------ | --- | --- |
requerimiento
| Tipo de  | Usabilidad   |     |     |
| -------- | ------------ | --- | --- |
requerimiento
Descripción del  El sistema debe proporcionar una interfaz intuitiva que permita
requerimiento  completar el proceso de registro y validación sin necesidad de
capacitación previa.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 26: Requerimiento No Funcional 9

| Código de  | RNF09   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Respaldo de información   |     |     |
| ----------- | ------------------------- | --- | --- |
requerimiento
| Tipo de  | Confiabilidad   |     |     |
| -------- | --------------- | --- | --- |
requerimiento
Descripción del  El sistema debe generar copias de seguridad automáticas de la
requerimiento  base de datos al menos una vez al día para garantizar la
recuperación de la información en caso de fallos.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 27: Requerimiento No Funcional 10
| Código de  | RNF10   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Registro de auditoría   |     |     |
| ----------- | ----------------------- | --- | --- |
requerimiento
| Tipo de  | Seguridad   |     |     |
| -------- | ----------- | --- | --- |
requerimiento
Descripción del  El sistema debe registrar todas las acciones relevantes de
requerimiento  validación, aprobación, rechazo y revisión administrativa para
fines de auditoría y trazabilidad.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 28: Requerimiento No Funcional 11
| Código de  | RNF11   |     |     |
| ---------- | ------- | --- | --- |
requerimiento
| Nombre del  | Escalabilidad del sistema  |     |     |
| ----------- | -------------------------- | --- | --- |
requerimiento
| Tipo de  | Rendimiento   |     |     |
| -------- | ------------- | --- | --- |
requerimiento
Descripción del  El sistema debe permitir el incremento de usuarios y solicitudes
requerimiento  de validación sin requerir modificaciones significativas en su
arquitectura.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 29: Requerimiento No Funcional 12
| Código de  | RNF12  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Mantenibilidad del software  |     |     |
| ----------- | ---------------------------- | --- | --- |
requerimiento
| Tipo de  | Calidad   |     |     |
| -------- | --------- | --- | --- |
requerimiento
Descripción del  El sistema debe desarrollarse siguiendo una arquitectura
requerimiento  modular y documentación técnica adecuada para facilitar
futuras correcciones, mejoras e integraciones.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 30: Requerimiento No Funcional 13

| Código de  | RNF13  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Integridad de la información   |     |     |
| ----------- | ------------------------------ | --- | --- |
requerimiento
| Tipo de  | Calidad   |     |     |
| -------- | --------- | --- | --- |
requerimiento
Descripción del  El sistema debe garantizar la consistencia e integridad de los
requerimiento  datos almacenados mediante validaciones y restricciones en la
base de datos.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 31: Requerimiento No Funcional 14
| Código de  | RNF14  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Recuperación ante fallos   |     |     |
| ----------- | -------------------------- | --- | --- |
requerimiento
| Tipo de  | Confiabilidad   |     |     |
| -------- | --------------- | --- | --- |
requerimiento
Descripción del  El sistema debe ser capaz de restaurar la información desde las
requerimiento  copias de seguridad en un tiempo máximo de 2 horas después
de un incidente crítico.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla  32: Requerimiento No Funcional 15
| Código de  | RNF15  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Capacidad de concurrencia   |     |     |
| ----------- | --------------------------- | --- | --- |
requerimiento
| Tipo de  | Rendimiento   |     |     |
| -------- | ------------- | --- | --- |
requerimiento
Descripción del  El sistema debe soportar al menos 100 solicitudes simultáneas
requerimiento  de validación sin degradar significativamente su rendimiento.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 33: Requerimiento No Funcional 16
| Código de  | RNF16  |     |     |
| ---------- | ------ | --- | --- |
requerimiento
| Nombre del  | Documentación técnica   |     |     |
| ----------- | ----------------------- | --- | --- |
requerimiento
| Tipo de  | Calidad   |     |     |
| -------- | --------- | --- | --- |
requerimiento
Descripción del  El sistema debe contar con documentación técnica actualizada
requerimiento  de la arquitectura, base de datos, API y procedimientos de
despliegue.
| Prioridad del  | Alta/Esencial  | Media/Deseado  | Baja/Opcional  |
| -------------- | -------------- | -------------- | -------------- |
requerimiento

Fuente: Elaboración Propia

Tabla 34: Requerimiento No Funcional 17
Código de RNF17
requerimiento
Nombre del Portabilidad del sistema
requerimiento
Tipo de Calidad
requerimiento
Descripción del El sistema debe poder desplegarse en servidores Linux
requerimiento utilizando contenedores Docker sin requerir modificaciones
significativas en el código fuente.
Prioridad del Alta/Esencial Media/Deseado Baja/Opcional
requerimiento
Fuente: Elaboración Propia

3.3. Historias de usuario
Tabla 35: Historia de Usuario 1
Código de HU01
requerimiento
Nombre de la Registro de usuaria
historia
Cómo Conductora o pasajera
Quiero Registrar mis datos personales en el sistema
Para Iniciar el proceso de validación de identidad
Criterios de El sistema solicita los datos obligatorios. Valida que los
aceptación campos requeridos estén completos. Almacena
correctamente la información registrada.
Fuente: Elaboración Propia
Tabla 36: Historia de Usuario 2
Código de HU02
requerimiento
Nombre de la Carga de documento de identidad
historia
Cómo Conductora o pasajera
Quiero Subir fotografías de mi cédula de identidad
Para Que el sistema pueda verificar la autenticidad de mi
documentación
Criterios de El sistema permite cargar imágenes válidas. Verifica que los
aceptación archivos sean legibles. Muestra una confirmación cuando la
carga se completa correctamente.
Fuente: Elaboración Propia

Tabla 37: Historia de Usuario 3
Código de HU03
requerimiento
Nombre de la Captura de fotografía facial
historia
Cómo Conductora o pasajera
Quiero Tomar una fotografía de mi rostro
Para Que el sistema compare mi identidad con la fotografía de mi
documento
Criterios de El sistema accede a la cámara del dispositivo. Permite
aceptación capturar la imagen facial. Valida que el rostro sea detectable
antes de continuar.
Fuente: Elaboración Propia
Tabla 38: Historia de Usuario 4
Código de HU04
requerimiento
Nombre de la Extracción automática de datos
historia
Cómo Conductora o pasajera
Quiero Que el sistema lea automáticamente la información de mi
documento
Para Evitar ingresar manualmente todos los datos personales
Criterios de El sistema extrae los datos mediante OCR. Muestra la
aceptación información obtenida. Permite corregir datos si existe algún
error de lectura.
Fuente: Elaboración Propia

Tabla 39: Historia de Usuario 5
Código de HU05
requerimiento
Nombre de la Verificación facial
historia
Cómo Conductora o pasajera
Quiero Que el sistema compare mi fotografía facial con la fotografía
de mi documento
Para Confirmar que soy la titular de la documentación presentada
Criterios de El sistema realiza la comparación biométrica. Calcula el
aceptación porcentaje de coincidencia. Genera un resultado de
validación.
Fuente: Elaboración Propia
Tabla 40: Historia de Usuario 6
Código de HU06
requerimiento
Nombre de la Detección de prueba de vida
historia
Cómo Conductora o pasajera
Quiero Demostrar que soy una persona real durante la validación
Para Evitar intentos de fraude mediante fotografías o videos
Criterios de El sistema ejecuta la prueba de vida. Detecta intentos de
aceptación suplantación. Permite continuar únicamente si la validación
es satisfactoria.
Fuente: Elaboración Propia

Tabla 41: Historia de Usuario 7
Código de HU07
requerimiento
Nombre de la Consulta del estado de validación
historia
Cómo Conductora o pasajera
Quiero Consultar el estado de mi proceso de verificación
Para Conocer si mi registro fue aprobado, rechazado o está
pendiente
Criterios de El sistema muestra el estado actualizado de la solicitud.
aceptación Indica la fecha de validación. Presenta observaciones
cuando existan.
Fuente: Elaboración Propia
Tabla 42: Historia de Usuario 8
Código de HU08
requerimiento
Nombre de la Revisión administrativa
historia
Cómo Administrador
Quiero Revisar solicitudes observadas por el sistema
Para Tomar una decisión final sobre la validación de identidad
Criterios de El sistema muestra la documentación y resultados
aceptación obtenidos. Permite aprobar o rechazar la solicitud. Registra
la decisión tomada.
Fuente: Elaboración Propia

Tabla 43: Historia de Usuario 9
Código de HU09
requerimiento
Nombre de la Gestión de registros verificados
historia
Cómo Administrador
Quiero Consultar el listado de usuarias registradas
Para Realizar seguimiento y control de las verificaciones
realizadas
Criterios de El sistema muestra los registros almacenados. Permite
aceptación realizar búsquedas y filtros. Presenta el estado de cada
validación.
Fuente: Elaboración Propia
Tabla 44: Historia de Usuario 10
Código de HU10
requerimiento
Nombre de la Visualización del historial de validaciones
historia
Cómo Administrador
Quiero Consultar el historial de verificaciones realizadas
Para Mantener la trazabilidad de los procesos de validación
Criterios de El sistema almacena cada validación realizada. Permite
aceptación consultar registros históricos. Muestra fecha, resultado y
observaciones.
Fuente: Elaboración Propia

Tabla 45: Historia de Usuario 11
Código de HU11
requerimiento
Nombre de la Notificación del resultado
historia
Cómo Conductora o pasajera
Quiero Recibir una notificación sobre el resultado de mi validación
Para Conocer oportunamente si puedo acceder al servicio
Criterios de El sistema envía una notificación al finalizar la validación.
aceptación Informa si la solicitud fue aprobada, rechazada o requiere
revisión adicional.
Fuente: Elaboración Propia
Tabla 46: Historia de Usuario 12
Código de HU12
requerimiento
Nombre de la Administración de parámetros de validación
historia
Cómo Administrador
Quiero Configurar los criterios utilizados en las validaciones
automáticas
Para Ajustar el funcionamiento del sistema según las
necesidades operativas
Criterios de El sistema permite modificar parámetros autorizados.
aceptación Guarda los cambios realizados. Aplica la nueva
configuración en futuras validaciones.
Fuente: Elaboración Propia

Tabla 47: Historia de Usuario 13
Código de HU13
requerimiento
Nombre de la Reenvío de documentación
historia
Cómo Conductora o pasajera
Quiero Volver a cargar mi documentación cuando sea observada o
rechazada
Para Corregir errores y completar exitosamente mi proceso de
validación
Criterios de El sistema permite reemplazar los documentos observados.
aceptación Notifica los motivos del rechazo. Inicia nuevamente el
proceso de validación después de la actualización.
Fuente: Elaboración Propia
Tabla 48: Historia de Usuario 14
Código de HU14
requerimiento
Nombre de la Gestión de usuarios administradores
historia
Cómo Administrador principal
Quiero Registrar y administrar cuentas de administradores
Para Delegar tareas de revisión y control dentro del sistema
Criterios de El sistema permite crear, editar y desactivar
aceptación administradores. Asigna permisos según el rol definido.
Registra las modificaciones realizadas.
Fuente: Elaboración Propia

Tabla 49: Historia de Usuario 15
Código de HU15
requerimiento
Nombre de la Consulta de evidencias de validación
historia
Cómo Administrador
Quiero Visualizar las imágenes utilizadas durante el proceso de
validación
Para Analizar y verificar manualmente los resultados obtenidos
por el sistema
Criterios de El sistema muestra la fotografía facial y el documento
aceptación cargado. Permite ampliar las imágenes. Mantiene la
información asociada a la solicitud correspondiente.
Fuente: Elaboración Propia
Tabla 50: Historia de Usuario 16
Código de HU16
requerimiento
Nombre de la Búsqueda avanzada de registros
historia
Cómo Administrador
Quiero Buscar usuarias mediante diferentes criterios
Para Localizar rápidamente registros específicos dentro del
sistema
Criterios de El sistema permite búsquedas por nombre, número de
aceptación documento y estado de validación. Muestra resultados
coincidentes. Permite combinar filtros.
Fuente: Elaboración Propia

Tabla 51: Historia de Usuario 17
Código de HU17
requerimiento
Nombre de la Generación de reportes de validación
historia
Cómo Administrador
Quiero Obtener reportes sobre los procesos de validación
realizados
Para Analizar estadísticas y monitorear el funcionamiento del
sistema
Criterios de El sistema genera reportes por rango de fechas. Incluye
aceptación cantidad de registros aprobados, rechazados y observados.
Permite exportar la información en formato PDF o Excel.
Fuente: Elaboración Propia

3.4. Casos de Uso
Los casos de uso describen las interacciones que los distintos tipos de
usuarios realizan con el sistema, especificando las funcionalidades
disponibles para cada uno. En el sistema de validación administrativa de
identidad y documentación se identifican tres actores principales: la Pasajera,
la Conductora y el Administrador. Cada actor cuenta con un conjunto de
casos de uso específicos según el rol que desempeña dentro del proceso de
registro y verificación.
3.4.1. Identificación de actores
Pasajera: usuaria que se registra en el sistema para acceder al
servicio en calidad de pasajera del transporte privado.
Conductora: usuaria que se registra en el sistema para acceder al
servicio en calidad de conductora del transporte privado.
Administrador: usuario interno encargado de revisar y resolver los
registros que el sistema deriva a validación manual cuando la
verificación automatizada no es concluyente
3.4.2. Casos de Uso del Sistema
Tabla 52: Caso de Uso - Autenticación al Sistema
Código CDU-01
Requerimiento asociado RF13
Nombre del caso de uso Autenticación al sistema
Actores Pasajera, Conductora, Administrador
Descripción Permite a las usuarias y al administrador ingresar al
sistema con sus credenciales según su rol.
Función 1. El actor ingresa correo y contraseña. 2. El sistema
valida las credenciales. 3. Identifica el rol y carga el
panel correspondiente.
Fuente: Elaboración Propia

Tabla 53: Caso de uso – Registro y verificación de identidad
Código CDU-02
Requerimiento asociado RF01, RF02, RF03, RF04, RF05, RF06, RF07, RF08
Nombre del caso de uso Registro y verificación de identidad
Actores Pasajera, Conductora
Descripción Ejecuta el flujo automatizado de validación: captura
de documento y rostro, extracción por OCR,
comparación facial, detección de vida y resultado.
Función 1. La usuaria carga el anverso y reverso de su
cédula. 2. Captura su fotografía facial. 3. El OCR
extrae los datos del documento. 4. El sistema valida
los parámetros de control de la cédula. 5. Compara
el rostro con la foto del documento. 6. Ejecuta la
detección de vida. 7. Aprueba el registro si supera el
umbral; si no, lo deriva a revisión.
Fuente: Elaboración Propia
Tabla 54: Caso de uso – Registro de pasajera
Código CDU-03
Requerimiento asociado RF01, RF12
Nombre del caso de uso Registro de pasajera
Actores Pasajera
Descripción Registra a una usuaria como pasajera y ejecuta sobre
ella la verificación de identidad.
Función 1. La pasajera ingresa sus datos y elige el rol de
pasajera. 2. El sistema ejecuta la verificación de
identidad (CDU-02). 3. Registra el resultado en su
cuenta. 4. Notifica el resultado a la pasajera.
Fuente: Elaboración Propia

Tabla 55: Caso de uso – Registro de conductora
Código CDU-04
Requerimiento asociado RF01, RF12
Nombre del caso de uso Registro de conductora
Actores Conductora
Descripción Registra a una usuaria como conductora, ejecuta
la verificación de identidad e incorpora la
validación del vehículo.
Función 1. La conductora ingresa sus datos y elige el rol de
conductora. 2. El sistema ejecuta la verificación de
identidad (CDU-02). 3. Solicita los datos del
vehículo y ejecuta su validación (CDU-05). 4.
Consolida ambos resultados en su cuenta. 5.
Notifica el resultado a la conductora.
Fuente: Elaboración Propia
Tabla 56: Caso de uso – Validación del vehículo
Código CDU-05
Requerimiento asociado RF01
Nombre del caso de uso Validación del vehículo
Actores Conductora
Descripción Valida los datos del vehículo declarado por la
conductora durante su registro.
Función 1. La conductora ingresa los datos del vehículo y
carga la documentación. 2. El sistema verifica
que los campos estén completos y con el formato
esperado. 3. Registra los datos del vehículo
asociados a la conductora.
Fuente: Elaboración Propia

Tabla 57: Caso de uso – Gestión de revisiones administrativas
Código CDU-06
Requerimiento asociado RF09, RF10, RF14
Nombre del caso de uso Gestión de revisiones administrativas
Actores Administrador
Descripción Permite al administrador revisar los registros
derivados a validación manual y tomar la decisión
final.
Función 1. Accede a la bandeja de registros observados.
2. Revisa la documentación, las imágenes y los
resultados automáticos. 3. Aprueba o rechaza la
solicitud. 4. El sistema actualiza el estado y
guarda la decisión con su autor y fecha. 5.
Notifica el resultado a la usuaria.
Fuente: Elaboración Propia
Tabla 58: Caso de uso – Gestión de usuarias del sistema
Código CDU-07
Requerimiento asociado RF11, RF14, RF15
Nombre del caso de uso Gestión de usuarias del sistema
Actores Administrador
Descripción Permite consultar, buscar y dar seguimiento a las
usuarias registradas y al estado de sus verificaciones.
Función 1. Accede al listado de usuarias. 2. Aplica filtros por
nombre, documento, fecha o estado. 3. El sistema
muestra los registros coincidentes. 4. Abre un registro
para ver su detalle.
Fuente: Elaboración Propia

Tabla 59: Caso de uso – Configuración de parámetros del sistema
Código CDU-08
Requerimiento asociado RF13
Nombre del caso de uso Configuración de parámetros del sistema
Actores Administrador
Descripción Permite ajustar los criterios de las validaciones
automáticas, como el umbral de coincidencia facial.
Función 1. Accede a la sección de parámetros. 2. Modifica
los valores autorizados. 3. El sistema los guarda y
los aplica en las validaciones posteriores.
Fuente: Elaboración Propia
Tabla 60: Caso de uso – Gestión de perfil de usuaria
Código CDU-09
Requerimiento asociado RF12, RF17
Nombre del caso de uso Gestión de perfil de usuaria
Actores Pasajera, Conductora
Descripción Permite a la usuaria consultar el estado de
su validación y reenviar documentación si
fue observada.
Función 1. Accede a su perfil y consulta el estado de
su verificación. 2. El sistema muestra el
estado, la fecha y las observaciones. 3. Si
fue observada, carga nuevamente la
documentación corregida. 4. El sistema
reinicia el flujo de verificación.
Fuente: Elaboración Propia

Tabla 61: Caso de uso – Generación de reportes
Código CDU-10
Requerimiento asociado RF16
Nombre del caso de uso Generación de reportes
Actores Administrador
Descripción Permite obtener reportes de las validaciones
realizadas en un período.
Función 1. Selecciona el rango de fechas. 2. El sistema
consolida los registros aprobados, rechazados y
observados. 3. Exporta el reporte en PDF o Excel.
Fuente: Elaboración Propia
Tabla 62: Caso de uso – Auditoría y trazabilidad
Código CDU-11
Requerimiento asociado RF11
Nombre del caso de uso Auditoría y trazabilidad
Actores Administrador
Descripción Permite consultar el historial de
validaciones y las acciones realizadas
sobre cada registro.
Función 1. Accede al historial de un registro o del
sistema. 2. El sistema muestra las
validaciones con fecha, resultado y
responsable. 3. Consulta el detalle de cada
acción.
Fuente: Elaboración Propia

Diagrama 1: Caso de uso – Autenticación al Sistema
Fuente: Elaboración Propia
Diagrama 2: Caso de uso: Registro y verificación de identidad
Fuente: Elaboración propia

Diagrama 3: Caso de uso – Gestión de revisiones administrativas
Fuente: Elaboración propia
Diagrama 4 — Registro de pasajera
Fuente: Elaboración propia

Diagrama 5 — Registro de conductora
Fuente: Propia

Diagrama 6 — Validación del Vehículo
Fuente: Elaboración Propia

Diagrama 7 — Gestión de revisiones administrativas
Fuente: Elaboración Propia
Diagrama 8 — Gestión de usuarias del sistema
Fuente: Elaboración Propia

Diagrama 9 — Configuración de parámetros del sistema
Fuente: Elaboración Propia

Diagrama 10 — Gestión de perfil de usuaria
Fuente: Elaboración Propia
Diagrama 11 — Generación de reportes
Fuente: Elaboración Propia

Diagrama 12 — Auditoría y trazabilidad
Fuente: Elaboración Propia
3.5. Modelo de reconocimiento facial
El reconocimiento facial es el núcleo de la validación y trabaja bajo el
esquema de verificación 1:1 visto en la sección 2.15: confirma si el rostro
capturado en vivo corresponde al de la fotografía de la cédula. No identifica
personas dentro de una base de datos (operación 1:N, fuera del alcance),
solo compara dos imágenes. El proceso tiene cinco etapas:
3.5.1. Captura
El frontend toma el anverso de la cédula y el rostro en vivo, y los
envía al backend en Laravel, que a su vez los manda al servicio de IA
mediante una petición POST a /verificar-rostro.

3.5.2. Detección de Vida
El rostro en vivo pasa por el modelo MiniFASNet
/detectar-liveness, que distingue entre una persona real y un
intento de suplantación con foto, pantalla o máscara. Si falla, el
registro se deriva a revisión administrativa.
3.5.3. Detección y alineación
Con RetinaFace (de DeepFace) se localiza y alinea el rostro en cada
imagen, lo que da robustez ante la iluminación y el ángulo de las fotos
de las cédulas bolivianas.
3.5.4. Extracción de embeddings
Cada rostro detectado pasa por el modelo ArcFace, una red neuronal
convolucional que devuelve un vector de 512 dimensiones con las
características únicas del rostro. Se eligió ArcFace por encima de
alternativas como Facenet512 a partir de pruebas previas al
desarrollo: con un umbral de 0,68, ArcFace se comportó mejor sobre
fotografías de cédulas con holograma —arrojó distancias del orden de
0,51 entre imágenes de la misma persona y de 0,84 entre personas
distintas—, mientras que Facenet512, con su umbral nominal de 0,30,
dio resultados inconsistentes sobre el mismo conjunto de prueba.
3.5.5. Comparación y veredicto
Se calcula la distancia entre ambos vectores: si es ≤ 0,68 los rostros
coinciden y el componente facial se aprueba; si es mayor, se rechaza.
El resultado y la distancia se guardan en la tabla
resultado_validacion. Cuando la distancia queda cerca del
umbral, el caso se deriva a revisión administrativa según el enfoque
híbrido.

|     |     | Fuente:  Elaboración Propia  |
| --- | --- | ---------------------------- |

3.6. Product Backlog
El product backlog es la lista priorizada de tareas con la que se organiza el
desarrollo bajo Scrum. Para este proyecto se construyó traduciendo los
requisitos funcionales y las historias de usuario en tareas técnicas
ejecutables el diseño de la base de datos, la configuración del entorno en
Laravel y la implementación de los modelos de IA en FastAPI, priorizando en
todo momento los componentes críticos de seguridad: el reconocimiento
facial y el OCR.
El backlog se gestionó en un tablero de Trello, que permitió planificar cada
sprint, seguir el progreso y mantener visible el estado de cada tarea a lo largo
del desarrollo.
Ilustración 19: Product Backlog
Fuente: Elaboración Propia

3.7. Análisis FODA
Fortalezas (F)
● Verificación de identidad con reconocimiento facial 1:1 y OCR sobre la
cédula boliviana, que ninguna plataforma de transporte del mercado
local aplica en el registro.
● Detección de vida (anti-spoofing) que impide burlar la verificación con
una fotografía, pantalla o máscara.
● Validación híbrida: lo automático resuelve la mayoría de los casos y
deriva solo los dudosos a revisión humana, equilibrando rapidez y
seguridad.
● Arquitectura modular en dos capas que permite ofrecer el módulo de
validación a otras plataformas.
● Construido íntegramente con tecnologías de código abierto que
corren localmente, sin costos de licencia ni dependencia de servicios
de pago.
Oportunidades (O)
● Demanda creciente y sostenida de transporte seguro para mujeres en
Bolivia, evidenciada por iniciativas como Móvil Rosa o Línea Lila.
● Vacío en el mercado: las plataformas locales de transporte privado no
verifican la identidad en el registro.
● Precedente del sector financiero, donde el eKYC ya validó estas
tecnologías sobre documentos bolivianos, lo que respalda su
adopción.
● Posibilidad de comercializar el módulo de validación como servicio a
otras empresas de transporte.
Debilidades (D)
● La precisión de la verificación depende de la calidad de las imágenes
que carga la usuaria (iluminación, enfoque, estado de la cédula).
● El alcance se limita a la cédula de identidad boliviana; otros
documentos no están contemplados.
● El sistema cubre solo la etapa de registro, no la operación del servicio
(viajes, pagos), que queda para fases posteriores.

● Al manejar datos biométricos, requiere controles de seguridad
estrictos que añaden complejidad al desarrollo.
Amenazas (A)
● Nuevas técnicas de suplantación y falsificación de documentos que
obliguen a actualizar los modelos.
● Riesgo de ciberataques o filtración de los datos biométricos
almacenados.
● Cambios en la normativa boliviana sobre protección de datos
personales y biométricos.
● Desconfianza de algunas usuarias frente al uso de reconocimiento
facial.
Estrategias derivadas del FODA
● FO (Fortalezas–Oportunidades): Posicionar la verificación facial +
OCR como el diferenciador frente a las plataformas que no verifican
identidad, y aprovechar el vacío del mercado para ofrecer el módulo
de validación a otras iniciativas de transporte.
● DO (Debilidades–Oportunidades): Incorporar guías visuales durante
la captura para mejorar la calidad de las imágenes, y apoyar el
alcance acotado (registro) en el precedente del eKYC para escalar
por etapas hacia la operación completa.
● FA (Fortalezas–Amenazas): Usar la detección de vida y la validación
híbrida para responder a los intentos de fraude, y mantener los
modelos actualizados frente a nuevas técnicas de falsificación.
● DA (Debilidades–Amenazas): Aplicar cifrado, control de acceso y
políticas de consentimiento informado sobre los datos biométricos
para mitigar riesgos de seguridad y responder a posibles cambios
normativos.

3.8. Diseño detallado
Diagrama de Base de Datos
Diagrama 13 — Diseño de la Base de Datos
Fuente propia
3.9. Tablas y campos
● usuario:
○ id_usuario (bigint)
○ correo (varchar)
○ contrasena_hash (varchar)
○ nombres (varchar)
○ apellidos (varchar)
○ telefono (varchar)
○ rol ("rol_pasajera_conductora_administrador_t")
○ activo (boolean)
○ fecha_registro (datetime)

● registro_verificacion:
○ id_registro (bigint)
○ id_usuario (bigint)
○ tipo_registro ("tipo_registro_pasajera_conductora_t")
○ ruta_selfie (varchar)
○ estado_resultado
("estado_resultado_pendiente_aprobado_rechazado_observa
do_t")
○ fecha (datetime)
● documento:
○ id_documento (bigint)
○ id_registro (bigint)
○ tipo_documento
("tipo_documento_cedula_licencia_soat_crpva_t")
○ ruta_imagen (varchar)
○ calidad_legible (boolean)
○ fecha_carga (datetime)
● dato_documento:
○ id_dato (bigint)
○ id_documento (bigint)
○ nombre_campo (varchar)
○ valor_extraido (varchar)
● vehiculo:
○ id_vehiculo (bigint)
○ id_registro (bigint)
○ placa (varchar)
○ marca_modelo (varchar)
○ color (varchar)
○ anio (int)
○ ruta_foto (varchar)
○ relacion_declarada
("relacion_declarada_propietaria_autorizada_tercero_t")
● parametro_control:
○ id_parametro (bigint)
○ tipo_documento
("tipo_documento_cedula_licencia_soat_crpva_t")
○ nombre_parametro (varchar)

○ categoria ("categoria_biometrico_documental_liveness_t")
○ es_bloqueante (boolean)
● resultado_validacion:
○ id_resultado (bigint)
○ id_registro (bigint)
○ id_parametro (bigint)
○ resultado ("resultado_aprobado_rechazado_observado_t")
○ detalle (text)
● revision:
○ id_revision (bigint)
○ id_registro (bigint)
○ id_administrador (bigint)
○ decision ("decision_aprobado_rechazado_reenvio_t")
○ observacion (text)
○ fecha (datetime)
● bitacora:
○ id_bitacora (bigint)
○ id_usuario (bigint)
○ tabla_afectada (varchar)
○ registro_afectado_id (bigint)
○ accion (varchar)
○ detalles (json)
○ fecha (datetime)
3.10. Relaciones entre tablas
El diseño de la base de datos articula las nueve tablas a través de relaciones
uno a muchos, que reflejan el flujo del proceso de validación de identidad: la
usuaria se registra, su registro de verificación agrupa los documentos y
vehículos declarados, sobre cada documento se extraen datos por OCR, y
cada parámetro del catálogo de control se evalúa generando resultados.
● usuario 1—n registro_verificacion: una misma usuaria puede tener
varios intentos de registro a lo largo del tiempo, cada uno con su
propio estado.

● usuario 1—n revision: un administrador, que es un usuario con rol
administrador, resuelve muchas revisiones a lo largo de su gestión.
● usuario 1—n bitacora: cada acción ejecutada por una usuaria o
administrador queda registrada en la bitácora con su autor.
● registro_verificacion 1—n documento: un registro puede incluir
varios documentos. En el caso de una conductora, agrupa la cédula,
la licencia, el SOAT y el CRPVA; en el caso de una pasajera,
solamente la cédula.
● registro_verificacion 1—n vehiculo: solo aplica a registros de
conductora; en la práctica corresponde a un vehículo por registro,
pero la cardinalidad uno a muchos brinda flexibilidad ante eventuales
escenarios con más de un vehículo declarado.
● registro_verificacion 1—n resultado_validacion: cada registro
produce un resultado por cada parámetro de control evaluado (match
facial, detección de vida, formato del número de cédula, coherencia
de fechas, entre otros).
● registro_verificacion 1—n revision: cuando un registro queda
observado, se asocia a una o más revisiones administrativas que
resuelven su estado final.
● documento 1—n dato_documento: cada documento contiene
múltiples datos extraídos por OCR, almacenados como pares de
nombre de campo y valor, lo que permite manejar campos distintos
según el tipo de documento sin modificar el esquema.
● parametro_control 1—n resultado_validacion: cada parámetro del
catálogo se aplica sobre muchos registros, generando un resultado
por cada evaluación realizada.

Capítulo IV.
Estudio de Factibilidad
1.
2.
3.

4. Factibilidad Técnica
El estudio de factibilidad evalúa si el proyecto es realizable desde tres perspectivas:
la disponibilidad de la tecnología necesaria (técnica), su capacidad de integrarse al
proceso real de registro (operativa) y la relación entre el esfuerzo de desarrollo y su
valor (económico).
4.1. Factibilidad técnica
El proyecto es técnicamente viable porque se apoya en tecnologías maduras,
de código abierto y ampliamente documentadas. El hardware necesario es
de uso común y el software no requiere licencias pagas.
● Hardware: un equipo de desarrollo, un servidor para el despliegue de
la aplicación web, una cámara web o de dispositivo móvil para la
captura facial y conexión a internet.
● Software: Laravel y MySQL para la aplicación web; HTML, CSS y
JavaScript para el frontend; Python con FastAPI para el servicio de
inteligencia artificial; y las librerías OpenCV, DeepFace (ArcFace,
RetinaFace, MiniFASNet) y de OCR para la verificación.
● Recursos humanos: el proyecto fue desarrollado por una sola
persona, que asumió los roles de análisis, desarrollo de la aplicación
web e implementación del componente de inteligencia artificial, en el
marco de un trabajo de grado académico.
Todas estas tecnologías son accesibles y de uso extendido, por lo que el
desarrollo es técnicamente factible.
4.2. Factibilidad operativa
El sistema automatiza la validación de identidad durante el registro de
usuarias, reemplazando una revisión manual que hoy es lenta y propensa al
error. Su operación aporta beneficios concretos: reduce los registros
fraudulentos, disminuye las revisiones manuales al resolver automáticamente
la mayoría de los casos, aumenta la confianza en la plataforma y mejora la
seguridad para conductoras y pasajeras.
Los usuarios involucrados son las conductoras y pasajeras, que se registran
y verifican su identidad, y el administrador, que gestiona las revisiones de los
casos derivados. Como el sistema se integra en la etapa de registro sin

alterar el resto del proceso, responde a una necesidad real y puede
adoptarse sin cambios significativos en la operación actual.
4.3. Factibilidad económica
La factibilidad económica se evalúa estimando el esfuerzo y el costo de
desarrollo mediante el modelo COCOMO II (Constructive Cost Model II) de
Barry Boehm, que calcula el esfuerzo, el tiempo y el personal necesarios a
partir del tamaño del software, expresado en miles de líneas de código fuente
(KSLOC), ajustado por las características del proyecto.
4.3.1. Estimación del tamaño del software
El tamaño se estimó descomponiendo el sistema en sus componentes:
Componente Lenguaje SLOC
Aplicación web (migraciones, PHP / Laravel 3.200
modelos Eloquent, controladores,
vistas Blade, middleware, servicios)
Servicio de IA (endpoints REST, Python / FastAPI 1.000
integración de ArcFace, RetinaFace,
MiniFASNet y OCR, utilidades)
Pruebas automatizadas PHP / Python 300
Total 4.500 SLOC = 4,5 KSLOC
4.3.2. Modelo COCOMO II
El esfuerzo en COCOMO II se calcula con la fórmula:
donde A = 2,94 (constante de calibración), E es un exponente que depende
de los factores de escala, y ∏(EM) es el producto de los multiplicadores de
esfuerzo.

a)  Factores de escala (determinan el exponente E)

|     | Factor  | Descripción      | Nivel     | Valor  |
| --- | ------- | ---------------- | --------- | ------ |
|     | PREC    | Precedencia del  | Nominal   | 3,72   |
proyecto
|     | FLEX  | Flexibilidad de  | Alto   | 2,03  |
| --- | ----- | ---------------- | ------ | ----- |
desarrollo
|     | RESL  | Resolución de  | Nominal   | 4,24  |
| --- | ----- | -------------- | --------- | ----- |
arquitectura/ries
go
|     | TEAM  | Cohesión del  | Muy alto   | 1,10  |
| --- | ----- | ------------- | ---------- | ----- |
equipo
|     | PMAT  | Madurez del  | Nominal   | 4,68  |
| --- | ----- | ------------ | --------- | ----- |
proceso
|     | ∑SF   |     | 15,77  |     |
| --- | ----- | --- | ------ | --- |
El exponente se obtiene con E = 0,91 + 0,01 · ∑SF:
E = 0,91 + 0,01 · 15,77 = 1,0677
b)  Multiplicadores de esfuerzo (determinan el EAF)

| CATEGORÍA  |                               | ATRIBUTO  | NIVEL  | VALOR  |
| ---------- | ----------------------------- | --------- | ------ | ------ |
| Producto   | RELY – Fiabilidad requerida   |           | Alto   | 1,10   |
| Producto   | DATA – Tamaño de la base      |           | Bajo   | 0,90   |
de datos
| Producto   | CPLX – Complejidad  |     | Alto   | 1,17  |
| ---------- | ------------------- | --- | ------ | ----- |
(módulo de IA)
| Producto     | RUSE – Reusabilidad    |     | Nominal   | 1,00  |
| ------------ | ---------------------- | --- | --------- | ----- |
| Producto     | DOCU – Documentación   |     | Nominal   | 1,00  |
| Plataforma   | TIME – Restricción de  |     | Nominal   | 1,00  |
tiempo de ejecución
| Plataforma   | STOR – Restricción de  |     | Nominal   | 1,00  |
| ------------ | ---------------------- | --- | --------- | ----- |
memoria
| Plataforma   | PVOL – Volatilidad de la  |     | Bajo   | 0,87  |
| ------------ | ------------------------- | --- | ------ | ----- |
plataforma
| Personal   | ACAP – Capacidad del  |     | Alto   | 0,85  |
| ---------- | --------------------- | --- | ------ | ----- |

analista
| Personal   | PCAP – Capacidad del  |     | Alto   | 0,88  |
| ---------- | --------------------- | --- | ------ | ----- |
programador
| Personal   | PCON – Continuidad del  |     | Muy alto   | 0,81  |
| ---------- | ----------------------- | --- | ---------- | ----- |
personal
| Personal   | APEX – Experiencia en la  |     | Bajo  | 1,10  |
| ---------- | ------------------------- | --- | ----- | ----- |
aplicación
| Personal   | PLEX – Experiencia en la  |     | Nominal   | 1,00  |
| ---------- | ------------------------- | --- | --------- | ----- |
plataforma
| Personal   | LTEX – Experiencia en  |     | Nominal   | 1,00  |
| ---------- | ---------------------- | --- | --------- | ----- |
lenguaje/herramientas
| Proyecto   | TOOL – Uso de  |     | Alto   | 0,90  |
| ---------- | -------------- | --- | ------ | ----- |
herramientas
| Proyecto   | SITE – Desarrollo en un  |     | Muy alto   | 0,80  |
| ---------- | ------------------------ | --- | ---------- | ----- |
solo sitio
| Proyecto   | SCED – Restricción de  |     | Nominal   | 1,00  |
| ---------- | ---------------------- | --- | --------- | ----- |
cronograma

El EAF es el producto de los 17 valores: ∏(EM) ≈ 0,48

c)  Cálculo del esfuerzo, tiempo y personal

| Variable  |     | Fórmula  |     | Resultado  |
| --------- | --- | -------- | --- | ---------- |
Esfuerzo (PM)   2,94 · (4,5)^1,0677 · 0,48   7,03 personas-mes
| Tiempo de desarrollo  | 3,67 · (7,03)^0,3115   |     | 6,7 meses   |     |
| --------------------- | ---------------------- | --- | ----------- | --- |
(TDEV)
| Personal promedio (P)   | 7,03 / 6,7   |     | ≈ 1 persona   |     |
| ----------------------- | ------------ | --- | ------------- | --- |

Donde el exponente del tiempo se calcula con F = 0,28 + 0,2 · (E − 0,91) =
0,3115. El resultado del personal promedio (≈1 persona) coincide con la
realidad del proyecto, desarrollado por una sola persona.

4.3.3. Estimación de costos
Aunque  el  modelo  COCOMO  II  estima  el  esfuerzo  a  precio  de
mercado, en este proyecto la mano de obra se registra en 0 Bs, ya
que  el  desarrollo  es  de  naturaleza  netamente  académica,
corresponde a un trabajo de grado y no persigue fines de lucro; por
ello, el esfuerzo de desarrollo se considera una inversión académica
no sujeta a remuneración.
Tabla 63 : Salario personal
|                     | Detalle  | Monto Mensual  |     | Subtotal (Bs)  |     |
| ------------------- | -------- | -------------- | --- | -------------- | --- |
| Sueldo (desarrollo  |          | 0 Bs           |     | 0 Bs           |     |
académico)
| Total   |     | 0 Bs  |     |     |     |
| ------- | --- | ----- | --- | --- | --- |
Fuente propia

Tabla 64: Detalle de Servicios Básicos

| Detalle           | Periodo de uso  |     | Costo mensual (bs)  |     | Subtotal  |
| ----------------- | --------------- | --- | ------------------- | --- | --------- |
| Agua              | 5               |     | 90                  |     | 450       |
| Electricidad      | 5               |     | 100                 |     | 500       |
| Red Wi-Fi (Tigo)  | 5               |     | 199                 |     | 995       |
| Total             |                 |     |                     |     | 1.945     |
Fuente propia

El costo real asumido durante el desarrollo se limita entonces a los
servicios y recursos necesarios para llevarlo a cabo:
Tabla 65 : Salario personal Costo real del desarrollo (5 meses)

| Detalle  |     | Subtotal (Bs)  |
| -------- | --- | -------------- |

| Salario personal (académico)                 |     | 0 Bs      |
| -------------------------------------------- | --- | --------- |
| Servicios básicos (internet, electricidad)   |     | 1.945 Bs  |

| Licencias de software (tecnologías de código  |     | 0 Bs  |
| --------------------------------------------- | --- | ----- |
abierto)

| TOTAL  |     | 1.945 Bs  |
| ------ | --- | --------- |
Fuente propia

4.3.4. Análisis comparativo de la estimación
A precio de mercado, el modelo COCOMO II estima un esfuerzo de
7,03 personas-mes y un tiempo de desarrollo de aproximadamente
6,7  meses  con  un  equipo  promedio  de  una  persona,  lo  que
equivaldría a un costo de 24.605 Bs si el proyecto se ejecutará en
condiciones comerciales (7,03 personas-mes × 3.500 Bs).
Tabla 66 : Costo total
Concepto  Cálculo  Costo Bs
| Mano de obra  | Esfuerzo COCOMO ×  | 24.605  |
| ------------- | ------------------ | ------- |
sueldo de referencia
| Licencia de software      | Código abierto   | 0      |
| ------------------------- | ---------------- | ------ |
| Servicios básicos         | Acumulado        | 1.945  |
| Costo total estimado por  | 26.550           |        |
COCOMO

Fuente propia

Sin embargo, el desarrollo real se ejecutó durante el semestre con un
único desarrollador y como trabajo de grado, motivo por el cual la
mano de obra no se traslada a ningún presupuesto y el costo
realmente asumido se reduce a 1.945 Bs. La diferencia entre ambos
valores no representa una inconsistencia, sino la distancia entre lo
que costaría producir el sistema en el mercado y el carácter
académico con que fue desarrollado. Visto así, el valor estimado por
COCOMO (26.550 Bs) funciona como referencia del valor real del
producto: frente a los beneficios de seguridad y reducción de fraude
que aporta, confirma la factibilidad económica del proyecto.

Capítulo V.
Conclusiones y Recomendaciones
1. s
2. s
3. f
4. s

5. Conclusiones
El análisis del mercado confirmó el problema de partida: las plataformas de
transporte privado de Santa Cruz Uber, InDrive, Yango aplican una verificación de
identidad deficiente al registrarse, basada sobre todo en datos declarados que no se
contrastan de forma confiable con el documento ni con el rostro de quien se inscribe;
las iniciativas para mujeres, como Móvil Rosa o Línea Lila, sí revisan documentos,
pero a mano y a criterio de una persona. Sobre ese diagnóstico se identificaron los
parámetros de control de la cédula boliviana (formato del número, coherencia de
fechas, vigencia, campos obligatorios y correspondencia con el formato del SEGIP);
además se constató que el código QR está cifrado y reservado al SEGIP, por lo que
no sirve para verificar a terceros.
Definidos los requisitos, se diseñó el flujo de validación híbrida y una arquitectura en
dos capas conectadas por una API REST: una aplicación web en Laravel y MySQL
para el registro, y un servicio en Python y FastAPI para el reconocimiento facial
(ArcFace), la detección de vida (MiniFASNet) y el OCR. La base de datos se
normaliza hasta la tercera forma normal para proteger los datos sensibles.
La evaluación respaldó las decisiones técnicas: sobre cédulas con holograma,
ArcFace con umbral de 0,68 dio distancias de ~0,51 entre imágenes de la misma
persona y ~0,84 entre personas distintas, y las pruebas del flujo completo
confirmaron que el sistema valida bien en condiciones normales y deriva los casos
dudosos a revisión administrativa.
Así, el objetivo general se cumplió. Respondiendo a la pregunta de investigación, la
confiabilidad del registro mejora combinando cuatro elementos verificación facial 1:1,
detección de vida, validación de la cédula por OCR y revisión administrativa de los
casos no concluyentes, lo que demuestra que la verificación de identidad con
inteligencia artificial es una propuesta viable para reducir el principal vacío de
seguridad del transporte privado local, mediante su implementación en plataformas
que hoy verifican de forma deficiente.

5.1. Recomendaciones
Se recomienda a las iniciativas de transporte privado de Santa Cruz de la
Sierra incorporar el módulo de validación de identidad como filtro en el
registro de conductoras y pasajeras, complementando la verificación manual
actual, y acompañarlo de un protocolo de revisión administrativa que
resuelva los casos derivados en un plazo máximo por ejemplo, 48 horas para
que la verificación no se convierta en un cuello de botella. Las imágenes de
cédula y los embeddings faciales deben almacenarse cifrados y bajo una
política de retención acotada, conforme a la normativa boliviana de
protección de datos y a las buenas prácticas para información biométrica.
Para futuras versiones del sistema, se recomienda extender su alcance a las
funciones que quedaron fuera de esta fase solicitud y asignación de viajes,
geolocalización, pagos y calificaciones, aprovechando que la arquitectura
modular fue diseñada para ello. En el plano técnico, conviene comprimir y
normalizar las imágenes en el frontend antes de enviarlas, para evitar las
demoras detectadas con archivos grandes, y evaluar la verificación 1:N
únicamente si la plataforma alcanza un volumen que lo justifique,
manteniendo la 1:1 como filtro de registro.
En el plano académico, se recomienda calibrar el umbral de ArcFace sobre
conjuntos más amplios de cédulas bolivianas que incluyan envejecimiento y
variaciones de calidad en la fotografía, estudiar modelos de detección de vida
más robustos frente a máscaras tridimensionales y deepfakes, y medir el
impacto social de la verificación obligatoria mediante estudios que comparen
la percepción de seguridad antes y después de su implementación.
Por último, se recomienda implementar el sistema desarrollado en la
iniciativa Lady's On Go y, más adelante, ofrecerlo como módulo integrable
para otras plataformas de transporte privado del mercado local, dado que su
modularidad y la madurez de las tecnologías empleadas lo vuelven una
solución viable y pertinente para el contexto cruceño.

Capítulo VI.
Referencias Bibliográficas
1.
2.
3.
4.
5.

6. Referencias
Bertalanffy, L. V. (1989). Teoría General de los Sistemas. Fondo de Cultura
Económica.
Jain, A. K., Ross, A., & Nandakumar, K. (2011). Introduction to Biometrics. Springer.
Laudon, K. C., & Laudon, J. P. (2020). Sistemas de Información Gerencial (16.ª ed.).
Pearson Educación.
Otwell, T. (2025). Laravel Documentation. Laravel Holdings Inc. Recuperado de
https://laravel.com/docs
Pressman, R. S., & Maxim, B. R. (2020). Ingeniería del Software: Un Enfoque
Práctico (9.ª ed.). McGraw-Hill Education.
Schroff, F., Kalenichenko, D., & Philbin, J. (2015). FaceNet: A Unified Embedding for
Face Recognition and Clustering. En Proceedings of the IEEE Conference on
Computer Vision and Pattern Recognition (CVPR) (pp. 815–823).
Silberschatz, A., Korth, H. F., & Sudarshan, S. (2020). Fundamentos de Bases de
Datos (7.ª ed.). McGraw-Hill Education.
Sommerville, I. (2016). Ingeniería de Software (10.ª ed.). Pearson Educación.
Stallings, W. (2018). Seguridad Informática: Principios y Práctica (4.ª ed.). Pearson
Educación.
Tesseract OCR Development Team. (2025). Tesseract Open Source OCR Engine.
Recuperado de https://github.com/tesseract-ocr/tesseract
World Wide Web Consortium (W3C). (2024). Web Security Standards and
Guidelines. Recuperado de https://www.w3.org
MySQL. (2025). MySQL Reference Manual. Oracle Corporation. Recuperado de
https://dev.mysql.com/doc
FilamentPHP. (2025). Filament Documentation. Recuperado de
https://filamentphp.com/docs

Anexos
Resultados de las encuestas
Para validar la pertinencia técnica y social, se aplicó una encuesta
estructurada a una muestra de 41 mujeres que representan el público
objetivo. A continuación, se detalla el análisis de cada interrogante bajo un
enfoque cuantitativo y cualitativo:
Fuente: Elaboración Propia
Análisis cuantitativo: El 70,7% de las encuestadas se encuentra entre los 18 y 25
años, seguido por un 19,5% entre 26 y 35 años, y un 9,8% entre 36 y 45 años.
Análisis cualitativo: La gran mayoría de las usuarias potenciales (más del 90%)
pertenece a una generación nativa digital, con alta familiaridad en el uso de
plataformas web y dispositivos móviles. Esto minimiza el riesgo de "fricción
tecnológica" al momento de interactuar con los módulos del sistema, garantizando
que el uso de la cámara para la prueba de vida (liveness) y la carga de documentos
no supondrán una barrera de entrada.

Fuente: Elaboración Propia
Análisis cuantitativo: El 92,7% respondió afirmativamente, mientras que solo el
7,3% indicó que no.
Análisis cualitativo: Se confirma y valida la delimitación espacial del proyecto
establecida en el Capítulo I. La concentración casi total de las encuestadas en el
cuarto anillo demuestra que la zona elegida para el caso de estudio de Lady's On Go
cuenta con la densidad de demanda necesaria para la implementación del sistema.

Fuente: Elaboración propia
Análisis cuantitativo: El 68,3% son estudiantes y el 22% trabajadoras
dependientes. Las trabajadoras independientes y amas de casa representan un
porcentaje menor.
Análisis cualitativo: El predominio de estudiantes y trabajadoras asalariadas
implica una necesidad de movilidad urbana frecuente y sujeta a horarios fijos. Este
nivel de exposición regular al transporte sustenta la necesidad de contar con una
plataforma que les garantice seguridad constante en sus trayectos rutinarios.

Fuente: Elaboración Propia
Análisis cuantitativo: El 56,1% las utiliza una vez por semana o menos, el 29,3%
varias veces por semana y casi un 5% de forma diaria. Un 9,8% casi nunca las usa.
Análisis cualitativo: El uso de transporte privado por aplicación es un hábito
arraigado. Al ser un servicio de uso recurrente, la implementación de un filtro de
seguridad estricto desde el registro impactará positivamente en la confianza a largo
plazo de las usuarias, justificando la inversión en el desarrollo del software.

Fuente: Elaboración propia
Análisis cuantitativo: La mayor concentración de uso se da en la noche (18:00 a
00:00) con un 85,4%, y en la tarde (12:00 a 18:00) con un 82,9%. La mañana
registra un 26,8%.
Análisis cualitativo: El uso masivo en horarios nocturnos coincide con las franjas
de menor visibilidad y mayor percepción de riesgo. En estas condiciones, es muy
difícil para una pasajera verificar visualmente la identidad del conductor. Esto hace
imprescindible que el sistema informático asuma esa carga, validando la identidad
mediante IA de forma automatizada antes de habilitar al usuario en la plataforma.

Fuente: Elaboración propia
Análisis cuantitativo: El 75,6% reportó cambios de ruta sin aviso, el 65,9%
conductores en estado sospechoso, el 58,5% conductores que insisten en
conversar, el 51,2% acoso verbal, el 36,6% acoso físico y el 9,8% intentos de robo.
Solo el 14,6% no ha sufrido ninguna de estas situaciones.
Análisis cualitativo: Más del 85% de las encuestadas ha sido víctima de algún
incidente, lo que evidencia el fracaso de los sistemas de registro actuales. La
validación biométrica y documental mediante OCR actúa como un disuasivo
fundamental: al saber que su identidad real ha sido verificada y almacenada, se
reduce drásticamente la sensación de impunidad del agresor, protegiendo a la
usuaria.

Fuente: Elaboración propia
Análisis cuantitativo: El 97,6% comparte su ubicación en tiempo real, el 65,9%
envía los datos o la placa a un contacto y el 41,5% simula una llamada.
Análisis cualitativo: La totalidad de las usuarias asume la carga de su propia
seguridad mediante métodos manuales. Sin embargo, compartir los datos del
conductor pierde utilidad si la cuenta en la app es falsa o suplantada. El sistema
propuesto resuelve esta falla estructural asegurando que los datos compartidos
pertenecen indudablemente a una persona verificada.

Fuente: Elaboración propia
Análisis cuantitativo: El 48,8% respondió "Sí, algunas veces" y el 17,1% "Sí,
muchas veces". Solo un 2,4% dijo "Nunca".
Análisis cualitativo: El miedo limita la libertad de movimiento en más del 65% de la
muestra. Esto demuestra que la inseguridad representa una pérdida directa de
usuarios para las plataformas convencionales, validando la oportunidad y viabilidad
comercial de Lady's On Go al ofrecer un entorno certificado mediante inteligencia
artificial.

Fuente: Elaboración propia
Análisis cuantitativo: El 46,3% lo califica como "Alto" y el 26,8% como "Muy alto".
Otro 26,8% indica un nivel "Medio". El 0% se siente seguro.
Análisis cualitativo: Estos datos ratifican de manera absoluta el problema central
planteado en el árbol de problemas del proyecto. La vulnerabilidad en el registro de
usuarios de las plataformas actuales genera un estado de alerta constante en las
pasajeras.

Fuente: Elaboración propia
Análisis cuantitativo: El 58,5% se siente "Poco segura" y el 41,5% "Algo segura".
Ninguna encuestada (0%) se siente "Totalmente segura".
Análisis cualitativo: La incertidumbre sobre la identidad es el punto ciego de las
aplicaciones actuales. Esta respuesta justifica de forma directa la implementación
del módulo de Reconocimiento Facial 1:1, el cual elimina las dudas humanas al
comparar algorítmicamente el rostro de la persona en vivo con la foto extraída de su
cédula oficial.

Fuente: Elaboración Propia
Análisis cuantitativo: El 75,6% "No está segura", un 19,5% cree que "Sí lo hacen"
y el resto sabe que "No lo hacen".
Análisis cualitativo: Existe una profunda opacidad respecto a los protocolos de
seguridad de las plataformas del mercado. Un sistema que sea explícito y
transparente en la exigencia de una verificación biométrica y documental al
momento del registro generará una fuerte ventaja competitiva y mayor confianza en
sus usuarias.

Fuente: Elaboración Propia
Análisis cuantitativo: El 51,2% lo considera "Importante" y el 31,7% "Muy
importante", sumando un 82,9% de respaldo positivo.
Análisis cualitativo: Las usuarias perciben la integración de tecnología avanzada
(IA y OCR) no como un obstáculo, sino como un requisito de valor indispensable
para el servicio. Esto valida los requisitos funcionales asociados a la extracción
automatizada de datos y la comprobación de los parámetros de control de la cédula.

Fuente: Elaboración propia
Análisis cuantitativo: El 68,3% está dispuesta pero "con dudas sobre privacidad",
mientras que el 31,7% lo haría "sin problema".
Análisis cualitativo: Aunque la disposición para realizar el proceso de verificación
es del 100%, la fuerte preocupación por la privacidad (68,3%) establece una
exigencia técnica crítica. Justifica plenamente la implementación de los Requisitos
No Funcionales de Seguridad (Triada CID), haciendo obligatorio el uso de
conexiones cifradas (HTTPS/TLS) y el almacenamiento seguro y encriptado de los
embeddings faciales y documentos.

Fuente: Elaboración Propia
Análisis cuantitativo: El 63,4% lo encuentra "Aceptable, pero preferiría que sea
más rápido" y el 36,6% indica "Sí, prefiero esa garantía adicional". Ninguna
consideró inaceptable la espera.
Análisis cualitativo: Esta métrica es fundamental, ya que valida el enfoque de
"Validación Administrativa Híbrida". Las usuarias demuestran total tolerancia a
sacrificar la inmediatez del registro a cambio de una mayor rigurosidad. Esto justifica
el desarrollo del módulo administrativo web, donde operadores humanos revisarán
los casos donde los algoritmos detecten puntajes de coincidencia dudosos.

Fuente: Elaboración propia
Análisis cuantitativo: El 43,9% marcó el nivel 4, y el 41,5% el nivel 5 (Muy
probable). Un 12,2% marcó el nivel 3.
Análisis cualitativo: Con más de un 85% de intención de confianza en los niveles
más altos, se concluye que el sistema propuesto es altamente viable y pertinente. El
uso de inteligencia artificial aplicada a la validación de identidades responde
directamente a la crisis de seguridad percibida por el público objetivo, validando la
construcción integral del software.
Entrevista a experta del área tecnológica
Como parte de la recolección de información para el proyecto, se sostuvo
una conversación con una desarrolladora de software externa a la
universidad, con experiencia en el área tecnológica, a quien se conoció en el
espacio de innovación Fab Lab Santa Cruz. La charla se llevó a cabo de
manera informal, pidiendo su opinión técnica sobre las principales decisiones
de diseño y de selección de tecnologías del sistema, con el fin de
complementar los datos recogidos en las encuestas con una mirada externa.

Pregunta N° 1. ¿Qué tan viable considera implementar reconocimiento facial y
OCR sobre la cédula de identidad boliviana?
Respuesta:
Es totalmente viable hoy en día. Los modelos pre-entrenados como ArcFace o
Facenet ya están probados y rinden bien si se cuida la calidad de la imagen. Para el
OCR sobre la cédula hay librerías como EasyOCR o Tesseract que funcionan
razonablemente; lo importante es trabajar la imagen antes de enderezarla, mejorar
el contraste. Lo más complicado no es el modelo, sino las cédulas en mal estado o
las fotos con poca luz.
Pregunta N° 2. ¿Qué le parece separar el sistema en una capa web (Laravel) y
un servicio de inteligencia artificial (Python con FastAPI)?
Respuesta:
Es la decisión correcta. Mezclar el Python de los modelos con el PHP de la
aplicación web complicaría todo. Tenerlos separados y comunicados por una API
REST permite desarrollar y probar cada parte por su lado, y si el módulo de IA crece,
no afecta a la aplicación web. Además, después se puede ofrecer el servicio de
validación a otras plataformas sin tener que mover nada del lado web.
Pregunta N° 3. ¿Qué importancia tiene incluir detección de vida (liveness) en
un sistema de este tipo?
Respuesta:
Es indispensable. Sin liveness, alguien sostiene una foto impresa frente a la cámara
y el sistema lo aprueba. En un servicio donde la seguridad de las usuarias está en
juego, eso es inaceptable. MiniFASNet es una opción liviana que cumple bien contra
los ataques más comunes foto, pantalla, máscara simple; contra máscaras 3D o
deepfakes ya se necesita algo más sofisticado, eso se podría dejar para una
siguiente versión o fase.

Pregunta N° 4. ¿Qué riesgos identifica en el manejo de datos biométricos y
cómo recomienda gestionarlos?
Respuesta:
El mayor riesgo es la filtración. Un correo se cambia y listo, pero una cara filtrada
acompaña a la persona toda su vida. Las imágenes y los embeddings tienen que ir
cifrados en la base, con acceso restringido a los procesos que realmente los
necesitan, y guardarlos solo el tiempo que haga falta. Y avisarle a la usuaria, con
consentimiento claro, qué se va a guardar y por cuánto tiempo.
Pregunta N° 5. ¿Qué le parece el enfoque de validación administrativa híbrida
decisión automática más revisión humana para los casos dudosos?
Respuesta:
Es el camino correcto. Confiar 100% en lo automático es arriesgado, sobre todo
cuando una mala foto puede dar un rechazo injusto. Y revisar todo a mano es
inviable cuando suben los volúmenes. El esquema híbrido resuelve ambos
problemas: lo automático se lleva la mayoría de los casos en segundos, y solo lo
dudoso pasa por una persona. Lo mismo hace la banca con los eKYC.
Conclusión de la conversación. Las opiniones recogidas respaldan las decisiones
técnicas del proyecto: la elección de los modelos de reconocimiento facial y OCR, la
arquitectura separada en dos capas, la incorporación de la detección de vida, el
manejo cifrado de los datos biométricos y el enfoque híbrido de validación.