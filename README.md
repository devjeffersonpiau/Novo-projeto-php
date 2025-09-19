# Projeto DevOps - Modernização de Aplicação PHP (Bolsa de Valores Mock)

Este repositório contém a solução do **Teste Técnico - Analista DevOps**, que consiste em modernizar uma aplicação web legada em PHP, aplicando as melhores práticas de **containerização**, **CI/CD** e **Infraestrutura como Código**.

---

## 📌 Etapa 1: Containerização da Aplicação

- Criação de um `Dockerfile` otimizado:
  - Baseado em `php:8.2-fpm-alpine`.
  - Multi-stage build.
  - Uso de **usuário não-root** para execução.
  - Configuração de extensões PHP necessárias (`pdo`, `pdo_mysql`, `opcache`, `intl`).

- Orquestração local via `docker-compose.yml`:
  - Serviço `php-fpm` para rodar a aplicação.
  - Serviço `nginx` para servir a aplicação web.
  - Volume mapeado em ambiente de desenvolvimento (`./src`).

---

## 📌 Etapa 2: Integração Contínua (CI)

Pipeline configurado em **GitHub Actions** (`.github/workflows/main.yml`):

1. **Checkout** do repositório.
2. **Build** da imagem Docker a partir do `Dockerfile`.
3. **Scan de vulnerabilidades** (Trivy).
4. **Push para o Docker Hub** → [`jeffersonp/bolsa-php`](https://hub.docker.com/r/jeffersonp/bolsa-php).

Secrets configurados:
- `DOCKERHUB_USERNAME`
- `DOCKERHUB_TOKEN`
- `SSH_HOST`
- `SSH_USER`
- `SSH_PRIVATE_KEY`

---

## 📌 Etapa 3: Infraestrutura como Código (IaC) e Deploy (CD)

- **Infraestrutura provisionada via Terraform no Azure**:
  - Criação de **VM Linux**.
  - Instalação do Docker e Docker Compose.

- **Arquivos de produção**:
  - `docker-compose.prod.yml`
  - `nginx.conf`

- **Pipeline CD**:
  - Após build e push da imagem no Docker Hub, a pipeline acessa a VM via SSH e executa:
    ```bash
    docker-compose -f docker-compose.prod.yml pull
    docker-compose -f docker-compose.prod.yml up -d --force-recreate
    ```

- Aplicação disponível em:
  - **App**: `http://<IP_PUBLICO>/`
  - **API**: `http://<IP_PUBLICO>/api/quote?symbol=PETR4`

---

## 📌 Etapa 4: Estratégia de Observabilidade

Stack escolhida:
- **Prometheus**: métricas da aplicação e containers.
- **Grafana**: dashboards e visualização.
- **Loki + Promtail**: logs centralizados.

Principais métricas coletadas:
1. **Disponibilidade da API** (status HTTP 200).
2. **Latência das requisições** (tempo de resposta).
3. **Uso de recursos da VM** (CPU, memória, rede).

---

## ✅ Conclusão

Esta solução entrega:
- Deploys rápidos, seguros e automatizados.
- Infraestrutura reprodutível via IaC.
- Observabilidade preparada para suportar escala.

---

## 📂 Estrutura do Repositório


