# Bolsa de Valores (Mock) – PHP + Nginx + Docker


Projeto de referência para subir rapidamente uma aplicação PHP servindo páginas e uma API simples de cotações **mockadas**.


## Como rodar


```bash
# 1) Build da imagem PHP
docker compose build


# 2) Subir o stack (Nginx + PHP-FPM)
docker compose up -d


# 3) Acessar
# Navegador: http://localhost:8080
# API: http://localhost:8080/api/quote?symbol=PETR4# Novo-projeto-php
# touch
# disparando pipeline
