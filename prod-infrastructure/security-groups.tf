resource "alicloud_security_group" "app_sg" {
  name        = "app_server"
  description = "App's Security group"
  vpc_id      = alicloud_vpc.muzawed_vpc.id
}
resource "alicloud_security_group" "bastion_sg" {
  name        = "bastion_server"
  description = "Bastion's Security group"
  vpc_id      = alicloud_vpc.muzawed_vpc.id
}

resource "alicloud_security_group_rule" "allow_bastion_to_ssh_app" {
  type                     = "ingress"
  ip_protocol              = "tcp"
  policy                   = "accept"
  port_range               = "22/22"
  priority                 = 1
  security_group_id        = alicloud_security_group.app_sg.id
  source_security_group_id = alicloud_security_group.bastion_sg.id
}
resource "alicloud_security_group_rule" "allow_bastion_ssh" {
  type              = "ingress"
  ip_protocol       = "tcp"
  policy            = "accept"
  port_range        = "22/22"
  priority          = 1
  security_group_id = alicloud_security_group.bastion_sg.id
  cidr_ip           = "0.0.0.0/0"
}
