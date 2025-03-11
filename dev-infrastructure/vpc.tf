resource "aws_vpc" "my-vpc" {
  cidr_block = "10.0.0.0/16"
  tags = {
    Name = "muzawed-vpc"
  }
}
resource "aws_subnet" "my-subnet" {
  cidr_block = "10.0.1.0/24"
  vpc_id = aws_vpc.my-vpc.id
  tags = {
    Name = "muzawed-public-subnet"
  }
}

resource "aws_internet_gateway" "my-igw" {
  vpc_id = aws_vpc.my-vpc.id
  tags = {
    Name = "muzawed-igw"
  }
}

resource "aws_route_table" "my-RT" {
  vpc_id = aws_vpc.my-vpc.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.my-igw.id
  }
    tags = {
    Name = "muzawed-route-table"
  }
}
resource "aws_route_table_association" "RT-association" {
  subnet_id = aws_subnet.my-subnet.id
  route_table_id = aws_route_table.my-RT.id
}

