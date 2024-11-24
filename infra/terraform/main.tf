terraform {
  required_version = "1.9.6"
  required_providers {
    aws = {
      version = "4.29.0"
      source  = "hashicorp/aws"
    }
  }
}

provider "aws" {
  access_key                  = "mock_access_key"
  secret_key                  = "mock_secret_key"
  region                      = var.region
  s3_use_path_style           = true
  skip_credentials_validation = true
  skip_metadata_api_check     = true
  skip_requesting_account_id  = true

  endpoints {
    apigateway     = var.localstack
    apigatewayv2   = var.localstack
    cloudformation = var.localstack
    cloudwatch     = var.localstack
    cloudwatchlogs = var.localstack
    dynamodb       = var.localstack
    ec2            = var.localstack
    es             = var.localstack
    elasticache    = var.localstack
    firehose       = var.localstack
    iam            = var.localstack
    kinesis        = var.localstack
    lambda         = var.localstack
    logs           = var.localstack
    rds            = var.localstack
    redshift       = var.localstack
    route53        = var.localstack
    s3             = var.localstack
    secretsmanager = var.localstack
    ses            = var.localstack
    sns            = var.localstack
    sqs            = var.localstack
    ssm            = var.localstack
    stepfunctions  = var.localstack
    sts            = var.localstack
  }

  default_tags {
    tags = local.common_tags
  }
}
