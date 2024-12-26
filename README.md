# Proyecto Viejita Distribuidora

Es un proyecto que realicé como Trabajo Final para mi Tecnicatura Universitaria en Programación. Consiste en un **E-commerce** para una distribuidora de alimentos, donde los clientes podrán realizar pedidos de productos tanto por unidad como por bulto. Tiene la opción de pagar por Mercado Pago o hacer un pedido para retirar en el local (no maneja envíos a domicilio). También incluye un panel de gestión de productos, empleados, pedidos, seguimiento de acciones de empleados y estadísticas en pesos de lo vendido en el mes y productos más o menos vendidos.

Desarrollado con **Vue 3** para el frontend y un **API REST** en **Laravel 11** para el backend.

## Repositorios en GitHub

- **Frontend:** [https://github.com/FernandoAriel80/distribuidora-front](https://github.com/FernandoAriel80/distribuidora-front)
- **Backend:** [https://github.com/FernandoAriel80/distribuidora-back](https://github.com/FernandoAriel80/distribuidora-back)

## Tabla de Contenidos

- [Instalación](#instalación)
- [Requisitos Previos](#requisitos-previos)
- [Uso](#uso)
- [Arquitectura del Proyecto](#arquitectura-del-proyecto)
- [API Endpoints](#api-endpoints)

## Instalación

### Backend (Laravel)

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/FernandoAriel80/distribuidora-back.git
    cd distribuidora-back
    ```

2. Instalar dependencias:
    ```bash
    composer install
    ```

3. Configurar el archivo `.env`:
    ```bash
    cp .env.example .env
    ```

4. Publicar configuraciones de CORS:
    ```bash
    composer show fruitcake/laravel-cors
    php artisan vendor:publish --provider="Fruitcake\Cors\CorsServiceProvider"
    ```

5. Crear enlaces simbólicos:
    ```bash
    php artisan storage:link
    ```

### Frontend (Vue 3)

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/FernandoAriel80/distribuidora-front.git
    cd distribuidora-front
    ```

2. Instalar dependencias:
    ```bash
    npm install
    ```

3. Ejecutar el servidor de desarrollo:
    ```bash
    npm run dev
    ```

## Requisitos Previos

- **Composer** versión 2.8.4
- **Node.js** versión 22.12.0
- **XAMPP** versión 8.2.12

Asegúrate de tener instalados los siguientes programas:

- Composer
- Node.js
- XAMPP
- Laravel 11
- Vue 3
- Tailwind CSS
- Axios
- Vite
- Git

## Uso

1. **Configurar el entorno:**
   - Asegúrate de que todos los requisitos previos estén instalados.
   - Edita el archivo `.env` para configurar las credenciales de la base de datos y otros servicios necesarios.

2. **Ejecutar el Backend:**
   - Inicia el servidor de Laravel:
     ```bash
     php artisan serve
     ```
   - Ejecuta las migraciones:
     ```bash
     php artisan migrate:refresh
     php artisan migrate:refresh --seed
     ```

   El backend se ejecutará en `http://127.0.0.1:8000`.

3. **Ejecutar el Frontend:**
   - Inicia el servidor de Vue:
     ```bash
     npm run dev
     ```
   El frontend se ejecutará en `http://localhost:5173`.

## Arquitectura del Proyecto

Este proyecto sigue una arquitectura basada en cliente-servidor, utilizando tecnologías modernas para el desarrollo web.

### Estructura General

El sistema está compuesto por dos partes principales:

1. **Backend (Laravel 11):** Encargado de la lógica de negocio, gestión de base de datos y exposición de una API RESTful.
2. **Frontend (Vue 3):** Encargado de la experiencia de usuario, proporcionando una interfaz interactiva para los clientes y administradores.

### Tecnologías Utilizadas

#### Backend:
- **Laravel 11:** Framework PHP para desarrollar la API REST.
- **MySQL:** Base de datos relacional.
- **Composer:** Gestor de dependencias de PHP.

#### Frontend:
- **Vue 3:** Framework JavaScript para construir la interfaz de usuario.
- **Tailwind CSS:** Framework CSS para diseño responsivo.
- **Axios:** Para realizar peticiones HTTP a la API REST.
- **Vite:** Herramienta de desarrollo para el frontend.

#### Otros:
- **Git:** Control de versiones.

## API Endpoints

### 1. Rutas Públicas

- **Página Principal**: `GET /`
- **Obtener todas las ofertas**: `GET /getAllOffer`
- **Obtener todos los productos**: `GET /getAll`

### 2. Categorías

- **Listar todas las categorías**: `GET /categories`
- **Ver una categoría específica**: `GET /categories/show/{id}`

### 3. Búsqueda

- **Buscar productos**: `GET /search`
- **Ver detalles de un producto después de la búsqueda**: `GET /search/show/{id}`

### 4. Rutas para Usuarios Invitados

- **Registro de usuario**: `POST /register`
- **Iniciar sesión**: `POST /login`

### 5. Rutas para Usuarios Autenticados

- **Obtener información del usuario autenticado**: `GET /user`
- **Cerrar sesión**: `POST /logout`
- **Dirección del usuario**: `GET /address`

### 6. Perfil del Usuario

- **Ver resumen del perfil**: `GET /profile/overview`
- **Actualizar información del perfil**: `PUT /profile/update_info`
- **Actualizar contraseña**: `PUT /profile/update_password`
- **Actualizar dirección del usuario**: `PUT /profile/update_address`
- **Eliminar cuenta de usuario**: `DELETE /profile/delete_account`

### 7. Carrito de Compras

- **Ver carrito de compras**: `GET /cart`
- **Agregar producto al carrito**: `POST /cart/create`
- **Eliminar producto del carrito**: `DELETE /cart/{id}`

### 8. Mercado Pago y Pagos

- **Procesar pago con Mercado Pago**: `POST /process_mercado_pago_payment`
- **Crear orden con Mercado Pago**: `POST /payment_mercado_pago_orders`
- **Crear orden para pago en tienda**: `POST /payment_in_store_orders`

### 9. Rutas de Administración

- **Administrar productos**: `GET /admin/products`
- **Administrar órdenes**: `GET /admin/orders`
- **Administrar empleados**: `GET /admin/employees`
- **Ver Dashboard de Administración**: `GET /admin/dashboard`

