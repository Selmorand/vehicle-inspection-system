# Password Management Guide

## 🔐 Security Rules

### NEVER DO:
- ❌ Copy production passwords to staging/local
- ❌ Store real passwords in code or configs
- ❌ Use production data in development
- ❌ Commit .env files to git
- ❌ Share database dumps with passwords

### ALWAYS DO:
- ✅ Use different passwords per environment
- ✅ Reset passwords when copying data
- ✅ Use strong passwords in production
- ✅ Use seeders for test accounts
- ✅ Document test credentials securely

## 📊 Environment Strategy

### Local Development
```bash
# Create local test users
php artisan db:seed --class=EnvironmentUserSeeder

# Test accounts:
admin@test.local / admin123
inspector@test.local / inspector123
```

### Staging
```bash
# Deploy and create staging users
./deploy-staging.sh

# Run seeder on staging
php artisan db:seed --class=EnvironmentUserSeeder --force

# Test accounts:
admin@alphainspections.co.za / StageAdmin2025!
inspector@alphainspections.co.za / StageInspect2025!
```

### Production
- Never seed users automatically
- Users register or are created manually
- Real passwords managed by users
- Password reset via email only

## 🔄 Syncing Data (Safe Method)

### From Production to Staging
```bash
# 1. Export structure only (no passwords)
mysqldump -u prod_user -p --no-data production_db > structure.sql

# 2. Export users with reset passwords
mysql -u prod_user -p production_db -e "
  SELECT name, email, role, created_at 
  FROM users
" > users.csv

# 3. Import to staging and reset passwords
php artisan users:sync-from-production --reset-passwords
```

### Test Data Creation
```php
// In staging, create realistic test data
User::factory()->count(10)->create([
    'password' => Hash::make('TestUser123!')
]);
```

## 🚀 Deployment Workflow

### 1. Local → Staging
```bash
git checkout staging
git merge feature-branch
git push origin staging
# GitHub Actions deploys and seeds test users
```

### 2. Staging → Production
```bash
git checkout production
git merge staging
git push origin production
# Production deployment (no user seeding)
```

## 🔑 Password Reset Scenarios

### Forgotten Staging Password
```bash
# SSH to staging
php artisan tinker
$user = User::where('email', 'inspector@alphainspections.co.za')->first();
$user->password = Hash::make('NewTestPassword123!');
$user->save();
```

### Bulk Password Reset (Staging Only)
```bash
php artisan users:sync-from-production --reset-passwords
```

## 📝 Environment Variables

### .env.local
```
APP_ENV=local
APP_DEBUG=true
ALLOW_TEST_LOGIN=true
```

### .env.staging
```
APP_ENV=staging
APP_DEBUG=false
ALLOW_TEST_LOGIN=true
TEST_MODE=true
```

### .env.production
```
APP_ENV=production
APP_DEBUG=false
ALLOW_TEST_LOGIN=false
TEST_MODE=false
```

## 🛠️ Troubleshooting

### Issue: Can't login to staging
```bash
# Check user exists
php artisan tinker
User::where('email', 'your@email.com')->first();

# Reset password
$user->password = Hash::make('NewPassword123!');
$user->save();
```

### Issue: Production passwords in staging
```bash
# Emergency password reset
php artisan users:sync-from-production --reset-passwords
```

### Issue: Need production-like data for testing
```bash
# Safe copy (structure + reset passwords)
./scripts/manage-staging-passwords.sh
# Choose option 3
```

## 📊 Quick Reference

| Environment | Password Strategy | Test Users | Data Source |
|------------|------------------|------------|-------------|
| Local | Simple (test123) | Auto-seeded | Factories |
| Staging | Complex (Stage123!) | Auto-seeded | Copied + Reset |
| Production | User-managed | None | Real users |

## 🔒 Security Checklist

- [ ] Different passwords per environment
- [ ] No production passwords in staging/local
- [ ] Test accounts documented
- [ ] Password reset works in all environments
- [ ] No passwords in git history
- [ ] Database backups encrypted
- [ ] Access logs monitored