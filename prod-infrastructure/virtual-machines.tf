resource "alicloud_instance" "app_server" {
  count             = 2
  availability_zone = data.alicloud_zones.availability_zones.zones[count.index].id
  security_groups   = [alicloud_security_group.app_sg.id]
  instance_type              = "ecs.t6-c1m2.large"
  system_disk_category       = "cloud_essd"
  system_disk_size           = 20
  system_disk_encrypted      = "true"
  image_id                   = "ubuntu_24_04_x64_20G_alibase_20240812.vhd"
  instance_name              = "app-server-${count.index}"
  vswitch_id                 = count.index == 0 ? alicloud_vswitch.private_vs_0.id : alicloud_vswitch.private_vs_1.id
  internet_max_bandwidth_out = 0
  instance_charge_type       = "PostPaid"
  key_name                   = alicloud_ecs_key_pair.sshkey.key_pair_name
  depends_on = [
  #######
]

 ## user_data = base64encode()
}

output "app_server_private_ips" {
  value = alicloud_instance.app_server.*.private_ip
}

resource "alicloud_instance" "bastion_server" {
  availability_zone = data.alicloud_zones.availability_zones.zones.0.id
  security_groups   = [alicloud_security_group.bastion_sg.id]
  instance_type              = "ecs.t6-c1m2.large"
  system_disk_category       = "cloud_essd"
  system_disk_size           = 20
  image_id                   = "ubuntu_24_04_x64_20G_alibase_20240812.vhd"
  instance_name              = "bastion"
  vswitch_id                 = alicloud_vswitch.public_vs_0.id
  internet_max_bandwidth_out = 100
  instance_charge_type       = "PostPaid"
  internet_charge_type       = "PayByTraffic"
  key_name                   = alicloud_ecs_key_pair.sshkey.key_pair_name

}

output "bastion_server_public_ip" {
  value = alicloud_instance.bastion_server.public_ip
}

resource "alicloud_instance" "monitoring_server" {
  availability_zone = data.alicloud_zones.availability_zones.zones.0.id
  security_groups   = [alicloud_security_group.app_sg.id]
  instance_type              = "ecs.t6-c1m2.large"
  system_disk_category       = "cloud_essd"
  system_disk_size           = 20
  system_disk_encrypted      = "true"
  image_id                   = "ubuntu_24_04_x64_20G_alibase_20240812.vhd"
  instance_name              = "monitoring_server"
  vswitch_id                 = alicloud_vswitch.private_vs_0.id
  internet_max_bandwidth_out = 0
  instance_charge_type       = "PostPaid"
  key_name                   = alicloud_ecs_key_pair.sshkey.key_pair_name

 ## user_data = base64encode()
}

output "monitoring_server_private_ip" {
  value = alicloud_instance.monitoring_server.private_ip
}