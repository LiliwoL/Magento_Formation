# Source:

	https://github.com/tuyennn/magento2-change-customer-password


# Intro

Change Customer Password In command line.

## Command-line usage

Call the console command and pass the customers email address and the new password.

```bash
bin/magento customer:change-password test@example.com password123 -w 1
```

If customer accounts are not shared between websites, a website code has to be specified with the `--website` or `-w`
option.

```bash
bin/magento customer:change-password --website base test@example.com password123
```