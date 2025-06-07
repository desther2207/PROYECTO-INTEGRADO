# 🎾 Square Pádel

**Square Pádel** es una plataforma web para la gestión y organización de torneos de pádel, pensada para facilitar el trabajo de los organizadores y mejorar la experiencia de los jugadores. El sistema automatiza la generación de partidos teniendo en cuenta horarios disponibles, pistas y más.

## 📌 Tabla de contenidos

- [Motivación](#motivación)
- [Tecnologías utilizadas](#tecnologías-utilizadas)
- [Características principales](#características-principales)
- [Instalación](#instalación)
- [Capturas de pantalla](#capturas-de-pantalla)
- [Despliegue en AWS](#despliegue-en-aws)
- [Dificultades encontradas](#dificultades-encontradas)
- [Conclusiones](#conclusiones)

---

## 💡 Motivación

Este proyecto nace de la experiencia personal ayudando a organizar el **Primer Torneo de Pádel de la Mancomunidad del Bajo Andarax**. El objetivo era automatizar al máximo la gestión de torneos: emparejamientos, asignación de horarios y pistas, cuadro de partidos, etc.

---

## 🛠️ Tecnologías utilizadas

- **Laravel 12** – Backend y sistema de autenticación
- **Livewire** – Componentes reactivos en tiempo real
- **Blade** – Motor de plantillas de Laravel
- **MySQL** – Base de datos (gestionada desde DBeaver)
- **Tailwind CSS** – Estilos modernos y responsive
- **FlatPickr** – Selección de fechas en español
- **Select2** – Selects con búsqueda y selección múltiple en formularios
- **JavaScript** – Funcionalidades dinámicas en el sistema
- **SweetAlert2** – Notificaciones bonitas

---

## 🚀 Características principales

### 🔐 Autenticación y roles

- Registro e inicio de sesión
- Control de acceso por roles: **usuario**, **editores (organizadores)**, **admin**

### 🏆 Gestión de torneos

- Crear torneos con categorías, sedes y fechas
- Generación automática de cuadros de partidos
- Inscripción por parejas mediante enlace de invitación
- Emparejamiento automático editable por administradores u organizadores

### 📅 Asignación inteligente de partidos

- Los partidos se asignan en función de:
  - Horarios NO disponibles de las parejas (elegidos en el momento de inscripción)
  - Pistas disponibles en las sedes
  - Tiempo de descanso mínimo entre partidos

### 🎮 Visualización de cuadros

- Vista editable por organizadores
- Resultados introducibles desde la interfaz
- Avance automático de rondas y cuadro de consolación

### 📈 Otras funcionalidades

- Vista de ranking de jugadores con estadísticas básicas
- Formulario de contacto para clubs

---

## 🧪 Instalación

# Clona el repositorio
```bash
git clone https://github.com/desther2207/PROYECTO-INTEGRADO.git
```
# Entra al proyecto
```bash
cd PROYECTO-INTEGRADO
```
# Instala dependencias backend
```bash
composer install
```
# Copia el archivo .env
```bash
cp .env.example .env
```
# Configura tus variables de entorno en .env

# Genera la key de la aplicación
```bash
php artisan key:generate
```
# Instala dependencias frontend
```bash
npm install && npm run build
```
# Ejecuta las migraciones
```bash
php artisan migrate --seed
```
# NOTA IMPORTANTE: --seed creará torneos que no son funcionales, ya que no se crean con todo lo necesario para cubrir toda la funcionalidad, por lo que se debe crear los torneos a mano para disfrutar de la funcionalidad completa del proyecto

# Inicia el servidor
```bash
php artisan serve
```
