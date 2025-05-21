data "alicloud_db_zones" "db_zones" {
  engine                   = "MySQL"
  engine_version           = "8.0"
  instance_charge_type     = "PostPaid"
  category                 = "HighAvailability"
  db_instance_storage_type = "cloud_essd"
}

data "alicloud_db_instance_classes" "db_classes" {
  zone_id                  = data.alicloud_db_zones.db_zones.zones.0.id
  engine                   = "MySQL"
  engine_version           = "8.0"
  category                 = "HighAvailability"
  instance_charge_type     = "PostPaid"
  db_instance_storage_type = "cloud_essd"
}
resource "alicloud_db_instance" "database" {
  engine                   = "MySQL"
  engine_version           = "8.0"
  category                 = "HighAvailability"
  instance_type            = data.alicloud_db_instance_classes.db_classes.instance_classes.0.instance_class
  instance_storage         = data.alicloud_db_instance_classes.db_classes.instance_classes.0.storage_range.min
  instance_charge_type     = "Postpaid"
  instance_name            = "muzawed_database"
  vswitch_id               = "${alicloud_vswitch.db_vs_0.id},${alicloud_vswitch.db_vs_1.id}"  
  monitoring_period        = "60"
  db_instance_storage_type = "cloud_essd"
  zone_id                  = data.alicloud_db_zones.db_zones.zones.0.id
  zone_id_slave_a          = data.alicloud_db_zones.db_zones.zones.1.id
}