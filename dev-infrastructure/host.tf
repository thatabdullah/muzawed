resource "aws_security_group" "my-sg" {
  name        = "muzawed-security-group"
  description = "Security group for dev host"
  vpc_id      = aws_vpc.my-vpc.id 

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]  
  }

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 8000
    to_port     = 8000
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}



resource "aws_instance" "host" {
  ami           = data.aws_ami.ubuntu.id
  instance_type = "t3.micro"
  key_name = var.ssh-key
  subnet_id = aws_subnet.my-subnet.id
  vpc_security_group_ids = [aws_security_group.my-sg.id]
  associate_public_ip_address = true
  user_data = base64encode(file("host-setup.sh"))
  root_block_device {
    volume_type = "gp3"
    volume_size = "30"
  }

  tags = {
    Name = "muzawed-dev-host"
  }
}
