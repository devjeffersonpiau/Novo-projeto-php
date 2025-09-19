output "public_ip" {
  description = "Endereço IP público da VM de aplicação"
  value       = azurerm_public_ip.pip.ip_address
}
