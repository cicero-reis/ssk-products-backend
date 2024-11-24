variable "region" {
  description = "AWS region"
  default     = "us-west-2"
}

variable "localstack" {
  description = "Variable endpoint localstack"
  type        = string
  default     = "http://localhost:4566"
}

variable "bucket_name" {
  description = "Bucket name"
  type        = string
  default     = "catalogapibucket"
}

