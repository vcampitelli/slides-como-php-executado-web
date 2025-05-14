# Como o PHP é executado na Web?

Essa palestra mostra alguns modelos de execução do PHP:

- Servidor embutido
- Apache
- Nginx e PHP-FPM
- Serverless
- Swoole
- RoadRunner
- FrankenPHP

## Slides

Acesse os slides em [viniciuscampitelli.com/slides-como-php-executado-web](https://viniciuscampitelli.com/slides-como-php-executado-web).

## Demos

Na pasta `demo`, temos 5 pastas com aplicações de demonstração, cada uma com uma configuração de [Docker Compose](https://docs.docker.com/compose) e rodando em uma porta diferente:

| Pasta           | Porta |
|-----------------|------:|
| `01-built-in`   | 8001  |
| `02-apache`     | 8002  |
| `03-nginx-fpm`  | 8003  |
| `04-serverless` | -     |
| `05-swoole`     | 8005  |
| `06-roadrunner` | 8006  |
| `07-frankenphp` | 8007  | 
