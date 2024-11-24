output "bucket_id" {
  description = "Id of the bucket"
  value       = aws_s3_bucket.catalog-api-bucket.id
}

output "bucket_arn" {
  description = "Arn of the bucket"
  value       = aws_s3_bucket.catalog-api-bucket.arn
}