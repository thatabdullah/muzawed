terraform {
  required_providers {
    alicloud = {
      source = "aliyun/alicloud"
      version = "1.217.0"
    }
  }
}
provider "alicloud" {
  access_key = var.access_key
  secret_key = var.secret_key
  region     = var.region
}

data "alicloud_regions" "current_region_ds" {
  current = true
}

output "current_region_id" {
  value = "${data.alicloud_regions.current_region_ds.regions.0.id}"
}
