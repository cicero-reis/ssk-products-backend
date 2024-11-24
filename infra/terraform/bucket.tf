resource "aws_s3_bucket" "catalog-api-bucket" {
  bucket = var.bucket_name
}