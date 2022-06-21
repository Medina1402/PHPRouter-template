# PHPRouter-template

### Requirements
- NodeJS V14.15.4 (*dev)
- MySQL V5.7.33
- PHP V7.4.19

### Install dependencies
```shell
npm install # yarn
```

### Run for development frontend
```shell
npm run dev # yarn dev
```

### Compiles and minifies for production
```shell
npm run build # yarn build
```

### Run server php
```shell
  #Or mount apache in **server**
  php -S localhost:8000 -t .\server
```

## Deploy to production
1. Build the javascript application
2. Copy the **server** folder to the host
> ***Create database and change properties to .env file***
