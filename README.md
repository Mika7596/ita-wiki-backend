# ITA Wiki Backend

## 📋 Descripción del Proyecto

**ITA Wiki Backend** es una API REST desarrollada en **Laravel 11** que funciona como un sistema de gestión de recursos educativos. El proyecto permite a los usuarios crear, gestionar y compartir recursos de aprendizaje organizados por categorías tecnológicas como Node.js, React, Angular, PHP Full Stack, Java, Data Science y BBDD.

### 🎯 Funcionalidades Principales

- **Gestión de Recursos**: Crear, leer, actualizar y eliminar recursos educativos
- **Sistema de Etiquetas**: Organización de recursos mediante tags personalizables
- **Autenticación GitHub**: Integración con GitHub OAuth para autenticación
- **Sistema de Roles**: Gestión de permisos (superadmin, admin, mentor, student)
- **Bookmarks**: Sistema de favoritos para recursos
- **Likes**: Sistema de valoración de recursos
- **Pruebas Técnicas**: Gestión de exámenes y evaluaciones
- **Documentación API**: Swagger/OpenAPI integrado

## 🏗️ Arquitectura del Proyecto

### Estructura de Carpetas

```
ita-wiki-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controladores principales
│   │   └── Requests/         # Validaciones de requests
│   ├── Models/               # Modelos Eloquent
│   ├── Observers/            # Observadores de modelos
│   ├── Providers/            # Proveedores de servicios
│   ├── Rules/                # Reglas de validación personalizadas
│   └── Services/             # Servicios de negocio
├── config/                   # Archivos de configuración
├── database/
│   ├── factories/            # Factories para testing
│   ├── migrations/           # Migraciones de base de datos
│   └── seeders/              # Seeders para datos iniciales
├── docker/                   # Configuración Docker
├── routes/                   # Definición de rutas
├── storage/                  # Almacenamiento de archivos
└── tests/                    # Tests automatizados
```

### Modelos Principales

#### 🔄 Transición GitHub ID → Node ID
El proyecto está en transición de usar `github_id` a `node_id` para mejor compatibilidad:

**Modelos Actuales (github_id):**
- `Role` - Gestión de roles de usuario
- `Resource` - Recursos educativos
- `Bookmark` - Favoritos de usuarios
- `Like` - Valoraciones de recursos
- `Tag` - Etiquetas para categorización

**Modelos Nuevos (node_id):**
- `RoleNode` - Gestión de roles con node_id
- `ResourceNode` - Recursos con node_id
- `BookmarkNode` - Favoritos con node_id
- `TagNode` - Etiquetas para recursos node
- `TechnicalTest` - Pruebas técnicas

### 📊 Base de Datos

#### Tablas Principales

1. **roles** / **roles_node**: Gestión de usuarios y permisos
2. **resources** / **resources_node**: Almacenamiento de recursos educativos
3. **tags** / **tags_node**: Sistema de etiquetado
4. **bookmarks** / **bookmarks_node**: Sistema de favoritos
5. **likes** / **likes_node**: Sistema de valoraciones
6. **technical_tests**: Gestión de pruebas técnicas

#### Categorías Soportadas

- Node.js
- React
- Angular
- JavaScript
- Java
- Fullstack PHP
- Data Science
- BBDD (Bases de Datos)

#### Tipos de Recursos

- Video
- Cursos
- Blog

## 🚀 Instalación y Configuración

### Prerrequisitos

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+
- Docker (opcional)

### Instalación Local

1. **Clonar el repositorio**
   ```bash
   git clone <repository-url>
   cd ita-wiki-backend
   ```

2. **Instalar dependencias PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias JavaScript**
   ```bash
   npm install
   ```

4. **Configurar entorno**
   ```bash
   cp .env.example .env
   # Editar .env con tus configuraciones
   ```

5. **Generar clave de aplicación**
   ```bash
   php artisan key:generate
   ```

6. **Configurar base de datos**
   ```bash
   php artisan migrate --seed
   ```

7. **Generar documentación Swagger**
   ```bash
   php artisan l5-swagger:generate
   ```

8. **Iniciar servidor de desarrollo**
   ```bash
   php artisan serve
   ```

### Instalación con Docker

1. **Construir y ejecutar contenedores**
   ```bash
   make up
   ```

2. **Acceder al contenedor PHP**
   ```bash
   docker exec -it php bash
   ```

3. **Ejecutar migraciones dentro del contenedor**
   ```bash
   php artisan migrate --seed
   ```

### Comandos Makefile Disponibles

```bash
make up          # Levantar contenedores Docker
make down        # Parar contenedores
make clean       # Limpiar Docker completamente
make serve       # Iniciar servidor Laravel en Docker
make cache-clear # Limpiar caché
make route-clear # Limpiar rutas
```

## 🔧 Configuración

### Variables de Entorno Principales

```env
# Aplicación
APP_NAME=ITA-Wiki
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ita_wiki
DB_USERNAME=root
DB_PASSWORD=

# GitHub OAuth
GITHUB_CLIENT_ID=your_client_id
GITHUB_CLIENT_SECRET=your_client_secret
GITHUB_REDIRECT_URI=http://localhost:8000/api/auth/github/callback

# Cache
CACHE_STORE=database

# Feature Flags
ALLOW_ROLE_SELF_ASSIGNMENT=true
```

## 🛠️ API Endpoints

### Autenticación

- `GET /api/auth/github/redirect` - Redirigir a GitHub OAuth
- `GET /api/auth/github/callback` - Callback de GitHub OAuth
- `POST /api/login` - Login con github_id
- `POST /api/login-node` - Login con node_id

### Recursos

- `GET /api/resources` - Listar recursos
- `POST /api/resources` - Crear recurso
- `PUT /api/resources/{id}` - Actualizar recurso
- `GET /api/v2/resources` - Listar recursos (v2 con node_id)
- `POST /api/v2/resources` - Crear recurso (v2 con node_id)

### Etiquetas

- `GET /api/tags` - Listar etiquetas
- `GET /api/tags/frequency` - Frecuencia de etiquetas
- `GET /api/tags/category-frequency` - Frecuencia por categoría
- `GET /api/tags/by-category` - Etiquetas por categoría

### Favoritos

- `GET /api/bookmarks/{github_id}` - Favoritos de usuario
- `POST /api/bookmarks` - Crear favorito
- `DELETE /api/bookmarks` - Eliminar favorito

### Valoraciones

- `GET /api/likes/{github_id}` - Likes de usuario
- `POST /api/likes` - Crear like
- `DELETE /api/likes` - Eliminar like

### Roles

- `POST /api/roles` - Crear rol
- `PUT /api/roles` - Actualizar rol
- `PUT /api/feature-flags/role-self-assignment` - Autoasignación de roles

### Pruebas Técnicas

- `POST /api/technicaltests` - Crear prueba técnica

## 📚 Documentación API

La documentación completa de la API está disponible en:
- **Desarrollo**: `http://localhost:8000/api/documentation`
- **Producción**: `https://your-domain.com/api/documentation`

La documentación se genera automáticamente usando Swagger/OpenAPI a partir de las anotaciones en los controladores.

## 🧪 Testing

### Ejecutar Tests

```bash
# Todos los tests
php artisan test

# Tests específicos
php artisan test --filter TagControllerTest

# Con coverage
php artisan test --coverage
```

### Estructura de Tests

- `tests/Feature/` - Tests de integración
- `tests/Unit/` - Tests unitarios

## 📦 Dependencias Principales

### Backend (PHP)
- **Laravel 11** - Framework principal
- **darkaonline/l5-swagger** - Documentación API
- **laravel/socialite** - Autenticación OAuth
- **laravel/tinker** - REPL para Laravel

### Frontend Assets
- **Vite** - Build tool
- **Tailwind CSS** - Framework CSS
- **PostCSS** - Procesamiento CSS
- **Autoprefixer** - Prefijos CSS automáticos

### Desarrollo
- **PHPUnit** - Testing framework
- **Laravel Pint** - Code styling
- **Laravel Sail** - Entorno Docker
- **Concurrently** - Ejecución de múltiples comandos

## 🚢 Despliegue

### Railway

El proyecto está configurado para despliegue en Railway:

```bash
railway up
```

El comando de inicio en Railway ejecuta:
```bash
php artisan db:wipe --force && 
php artisan migrate --force --seed && 
php artisan l5-swagger:generate && 
php artisan cache:clear && 
php artisan config:clear && 
php artisan route:clear && 
php artisan view:clear && 
php artisan serve --host=0.0.0.0 --port=8080
```

### Docker

```bash
# Construir imagen
docker build -t ita-wiki-backend .

# Ejecutar contenedor
docker run -p 8000:8000 ita-wiki-backend
```

## 🔒 Seguridad

### Roles de Usuario

1. **superadmin** - Acceso completo al sistema
2. **admin** - Gestión de usuarios y contenido
3. **mentor** - Creación y gestión de recursos
4. **student** - Consumo de recursos y creación limitada

### Feature Flags

- `allow_role_self_assignment` - Permitir autoasignación de roles

### Validaciones

- Validación de GitHub IDs reales
- Sanitización de URLs
- Límites de etiquetas por recurso (máximo 5)
- Validación de categorías y tipos permitidos

## 🐛 Debugging y Logging

### Logs Disponibles

```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Limpiar logs
php artisan log:clear
```

### Errores Comunes

1. **Error de migración**: Verificar conexión a base de datos
2. **Error de permisos**: Verificar permisos de carpetas storage y bootstrap/cache
3. **Error de GitHub OAuth**: Verificar configuración de credenciales

## 🤝 Contribución

### Flujo de Desarrollo

1. Fork del repositorio
2. Crear rama feature: `git checkout -b feature/nueva-funcionalidad`
3. Commit cambios: `git commit -m "Agregar nueva funcionalidad"`
4. Push a rama: `git push origin feature/nueva-funcionalidad`
5. Crear Pull Request

### Estándares de Código

- Seguir PSR-12 para PHP
- Usar Laravel Pint para formatting: `composer run pint`
- Documentar métodos con PHPDoc
- Escribir tests para nuevas funcionalidades

### Convenciones de Nombres

- Controladores: `PascalCase` + `Controller`
- Modelos: `PascalCase` singular
- Migraciones: `snake_case` con timestamp
- Rutas: `kebab-case`

## 📋 Roadmap

### Próximas Funcionalidades

- [ ] Sistema de comentarios en recursos
- [ ] Notificaciones push
- [ ] API GraphQL
- [ ] Sistema de reportes y analytics
- [ ] Integración con más proveedores OAuth
- [ ] Sistema de moderación de contenido
- [ ] API de recomendaciones basada en ML

### Mejoras Técnicas

- [ ] Migración completa a node_id
- [ ] Implementación de cache Redis
- [ ] Rate limiting avanzado
- [ ] Optimización de consultas DB
- [ ] Implementación de WebSockets
- [ ] Migración a PHP 8.4

## 📞 Soporte

### Recursos de Ayuda

- **Documentación Laravel**: https://laravel.com/docs
- **GitHub Issues**: Para reportar bugs y solicitar features
- **Slack/Discord**: Canal de desarrollo del equipo

### Contacto

- **Email**: desarrollo@itacademy.com
- **Slack**: #ita-wiki-backend

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo `LICENSE` para más detalles.

---

**¡Bienvenido al equipo de desarrollo de ITA Wiki! 🚀**

¿Necesitas ayuda? No dudes en preguntar en nuestros canales de comunicación o crear un issue en GitHub.

## Contributors

Luis Vicente
Jordi Morillo 
Juan Valdivia 
Raquel Martínez 
Stéphane Carteaux 
Diego Chacón 
Óscar Anguera 
Rossana Liendo 
Constanza Gómez 
Xavier R 
Sergio López 
Frank Pulido (@frankpulido) 
Raquel Patiño 
Anna Mercado 
Lena Prado 
Kawsu Nagib 
Simón Menendez Bravo
Guillem Gaona Borastero
Michelle Di Terlizzi
Ivonne Cantor Páez
Cristina Cardona