# Image Meta
This is an api collection to store, view and download image metadata.

### See the [demo](http://imagemeta.ostris.net/) application.

Frontend: `VUE`
Backend: `LARAVEL`

## Backend setup
```
cd backend
```
```
composer install
```

Create the .env file from .env.example and add the proper database configuration.

#### Migrate the database
```
php artisan migrate
```

#### Run the backend project
```
php artisan serve
```

## Frontend setup
```
cd frontend
```

Create the .env file from .env.example and add edit the `VUE_APP_API_URL` if required.

Require node.js and vue-cli installed.

#### install node modules
```
npm install
```

#### Run the frontend project
```
npm run serve
```

##### Visit http://localhost:8080
