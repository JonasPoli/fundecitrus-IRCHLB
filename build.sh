#!/bin/bash
rm -rf var/cache

# Cores para o output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Detectar binário do PHP
PHP_BIN="/RunCloud/Packages/php82rc/bin/php"
if [ ! -f "$PHP_BIN" ]; then
    if command -v php82 &> /dev/null; then
        PHP_BIN="php82"
    elif command -v php84 &> /dev/null; then
        PHP_BIN="php84"
    else
        PHP_BIN="php"
    fi
fi

echo -e "${BLUE}==> Iniciando deploy / build do sistema...${NC}"

# 1. Executar Migrações do Banco de Dados
echo -e "${GREEN}--> Executando migrações do banco de dados...${NC}"
$PHP_BIN bin/console doctrine:migrations:migrate --no-interaction

# 2. Limpar Cache do Symfony
echo -e "${GREEN}--> Limpando cache do Symfony...${NC}"
$PHP_BIN bin/console cache:clear
rm -rf var/cache/*

# 3. Limpar Cache de Imagens (LiipImagine)
if [ -d "public/media/cache" ]; then
    echo -e "${GREEN}--> Removendo miniaturas (LiipImagine)...${NC}"
    rm -rf public/media/cache/*
fi

# 4. Recompilar Tailwind CSS (minificado)
echo -e "${GREEN}--> Recompilando Tailwind CSS...${NC}"
$PHP_BIN bin/console tailwind:build --minify

# 5. Compilar Assets (Asset Mapper)
echo -e "${GREEN}--> Compilando AssetMap...${NC}"
$PHP_BIN bin/console asset-map:compile

# 6. Limpar Logs
echo -e "${GREEN}--> Limpando logs...${NC}"
rm -rf var/log/*

echo -e "${BLUE}==> Deploy / Build concluído com sucesso!${NC}"
