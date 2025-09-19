variable "project" {
  type    = string
  default = "bolsa-php"
}

variable "rg_name" {
  type    = string
  default = "bolsa-php-rg"
}

variable "location" {
  type = string
  # Sugestões de região: "eastus", "brazilsouth"
  default = "eastus"
}

variable "vm_size" {
  type    = string
  default = "Standard_B1s" # econômico para testes
}

variable "admin_user" {
  type    = string
  default = "azureuser"
}

variable "public_key_path" {
  type        = string
  description = "Caminho da chave pública SSH (ex.: ~/.ssh/id_rsa.pub)"
}

variable "ssh_cidr" {
  type        = string
  description = "CIDR permitido para SSH (22/tcp). Em produção, restrinja!"
  default     = "0.0.0.0/0"
}

variable "dockerhub_username" {
  type        = string
  description = "Usuário do Docker Hub para tag da imagem de produção"
}