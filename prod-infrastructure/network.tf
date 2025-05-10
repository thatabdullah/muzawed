data "alicloud_zones" "availability_zones" {
  available_resource_creation = "VSwitch"
}

resource "alicloud_vpc" "muzawed_vpc" {
  cidr_block = "10.0.0.0/16"
}
resource "alicloud_vswitch" "public_vs_0" {
  cidr_block = "10.0.1.0/24"
  vpc_id = alicloud_vpc.muzawed_vpc.id
  zone_id = data.alicloud_zones.availability_zones.zones.0.id
}

resource "alicloud_vswitch" "public_vs_1" {
  cidr_block = "10.0.2.0/24"
  vpc_id = alicloud_vpc.muzawed_vpc.id
  zone_id = data.alicloud_zones.availability_zones.zones.1.id
}
resource "alicloud_vswitch" "private_vs_0" {
  cidr_block = "10.0.3.0/24"
  vpc_id = alicloud_vpc.muzawed_vpc.id
   zone_id = data.alicloud_zones.availability_zones.zones.0.id
}
resource "alicloud_vswitch" "private_vs_1" {
  cidr_block = "10.0.4.0/24"
  vpc_id = alicloud_vpc.muzawed_vpc.id
  zone_id = data.alicloud_zones.availability_zones.zones.1.id
}
resource "alicloud_vswitch" "db_vs_0" {
  cidr_block = "10.0.5.0/24"
  vpc_id = alicloud_vpc.muzawed_vpc.id
  zone_id = data.alicloud_zones.availability_zones.zones.0.id
}
resource "alicloud_vswitch" "db_vs_1" {
  cidr_block = "10.0.6.0/24"
  vpc_id = alicloud_vpc.muzawed_vpc.id
  zone_id = data.alicloud_zones.availability_zones.zones.1.id
}


resource "alicloud_route_table" "muzawed_route_table" {
  vpc_id = alicloud_vpc.muzawed_vpc.id
  route_table_name = "muzawed_route_table"
  associate_type = "VSwitch"
}
resource "alicloud_route_table_attachment" "route_table_attachment_1" {
  vswitch_id = alicloud_vswitch.private_vs_0.id
  route_table_id = alicloud_route_table.muzawed_route_table.id
}
resource "alicloud_route_table_attachment" "route_table_attachment_2" {
  vswitch_id = alicloud_vswitch.private_vs_1.id
  route_table_id = alicloud_route_table.muzawed_route_table.id
}
resource "alicloud_nat_gateway" "nat_gateway" {
  vpc_id = alicloud_vpc.muzawed_vpc.id
  nat_gateway_name = "muzawed_nat"
  payment_type = "PayAsYouGo"
  vswitch_id = alicloud_vswitch.public_vs_0.id
  nat_type = "Enhanced"
}
resource "alicloud_eip_address" "NAT_eIP" {
  description = "nat's elastic IP"
  address_name = "NAT"
  netmode = "public"
  bandwidth = "100"
  payment_type = "PayAsYouGo"
  internet_charge_type = "PayByTraffic"
}
resource "alicloud_eip_association" "eIP_association" {
  instance_type = "Nat"  
  instance_id = alicloud_nat_gateway.nat_gateway.id
  allocation_id = alicloud_eip_address.NAT_eIP.id
}
resource "alicloud_snat_entry" "Snat_entry_1" {
  snat_ip = alicloud_eip_address.NAT_eIP.ip_address
  snat_table_id = alicloud_nat_gateway.nat_gateway.id
  source_vswitch_id = alicloud_vswitch.private_vs_0.id
}
resource "alicloud_snat_entry" "Snat_entry_2" {
  snat_ip = alicloud_eip_address.NAT_eIP.ip_address
  snat_table_id = alicloud_nat_gateway.nat_gateway.id
  source_vswitch_id = alicloud_vswitch.private_vs_1.id
}
resource "alicloud_route_entry" "private_route_entry" {
  route_table_id = alicloud_route_table.muzawed_route_table.id
  destination_cidrblock = "0.0.0.0/0"
  nexthop_type = "NatGateway"
  nexthop_id = alicloud_nat_gateway.nat_gateway.id
}