data "alicloud_resource_manager_resource_groups" "default" {
}

data "alicloud_alb_zones" "default" {
}

resource "alicloud_alb_load_balancer" "load_balancer" {
  load_balancer_edition  = "Basic"
  address_type           = "Internet"
  vpc_id                 = alicloud_vpc.muzawed_vpc.id
  address_ip_version = "Ipv4"
  address_allocated_mode = "Fixed"
  resource_group_id      = data.alicloud_resource_manager_resource_groups.default.groups.0.id
  load_balancer_name     = "muzawedLoadBalancer"
  load_balancer_billing_config {
    pay_type = "PayAsYouGo"
  }
  modification_protection_config {
    status = "NonProtection"
  }
  zone_mappings {
    vswitch_id = alicloud_vswitch.private_vs_0.id
    zone_id    = alicloud_vswitch.private_vs_0.zone_id
  }
  zone_mappings {
    vswitch_id = alicloud_vswitch.private_vs_1.id
    zone_id    = alicloud_vswitch.private_vs_1.zone_id
  }
  tags = {
    Created = "TF"
  }
}

resource "alicloud_alb_server_group" "app_servers_group" {
    server_group_name = "muzawed-ecs-group"
    vpc_id            = alicloud_vpc.muzawed_vpc.id
    protocol          = "HTTP"
    health_check_config {
        health_check_enabled = true
        health_check_protocol = "HTTP"
        health_check_path     = "/"
        health_check_interval = 5
        healthy_threshold     = 3
        unhealthy_threshold   = 3
  }
  servers {
    description = "server 1"
    port        = 80
    server_id   = alicloud_instance.app_server[0].id
    server_ip   = alicloud_instance.app_server[0].private_ip
    server_type = "Ecs"
    weight      = 10
  }
  servers {
    description = "server 1"
    port        = 80
    server_id   = alicloud_instance.app_server[1].id
    server_ip   = alicloud_instance.app_server[1].private_ip
    server_type = "Ecs"
    weight      = 10
  }
}

resource "alicloud_alb_listener" "http_listener" {
 load_balancer_id     = alicloud_alb_load_balancer.load_balancer.id
  listener_protocol    = "HTTP"
  listener_port        = 80
  listener_description = "alb_listener"
  default_actions {
    type = "ForwardGroup"
    forward_group_config {
      server_group_tuples {
        server_group_id = alicloud_alb_server_group.app_servers_group.id
      }
    }
  }
}