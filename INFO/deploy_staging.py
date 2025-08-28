#!/usr/bin/env python3
import subprocess
import sys

print("="*50)
print("AUTOMATED STAGING DEPLOYMENT")
print("="*50)

commands = [
    "cd /home/alphains/staging",
    "git pull origin staging", 
    "php artisan config:clear",
    "php artisan cache:clear",
    "php artisan view:clear",
    "php artisan route:clear",
    "echo 'DEPLOYMENT COMPLETE!'"
]

# Combine all commands
full_command = " && ".join(commands)

print(f"\nConnecting to alphainspections.co.za:22000...")
print(f"Password: Suq8h0QkFB[+18\n")

# Try to run SSH command
ssh_command = f'ssh -p 22000 alphains@alphainspections.co.za "{full_command}"'
print(f"Running: {ssh_command}\n")

try:
    result = subprocess.run(ssh_command, shell=True, capture_output=False, text=True)
    if result.returncode == 0:
        print("\n✅ Deployment successful!")
    else:
        print(f"\n❌ Deployment failed with code: {result.returncode}")
except Exception as e:
    print(f"\n❌ Error: {e}")