#!/bin/bash

echo "Testing connection to staging server..."
echo "========================================="

# Test SSH connection
ssh -i staging_deploy_key -o StrictHostKeyChecking=no selproho@169.239.218.62 "echo 'SSH connection successful!'; pwd; ls -la"

echo ""
echo "If you see 'SSH connection successful!' above, your SSH key is working!"
echo "Next steps:"
echo "1. SSH into server: ssh -i staging_deploy_key selproho@169.239.218.62"
echo "2. Navigate to: cd /public_html"
echo "3. Clone repo: git clone https://github.com/Selmorand/vehicle-inspection-system.git staging.alphainspections.co.za"
echo "4. Enter directory: cd staging.alphainspections.co.za"
echo "5. Switch branch: git checkout staging"
echo "6. Run deployment: ./deploy-to-staging.sh"