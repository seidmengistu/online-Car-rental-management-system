# Carola Car Rental - Authentication System

This document describes the comprehensive authentication system implemented for the Carola Car Rental application with support for three user roles: **Customers**, **Staff**, and **Managers**.

## 🏗️ System Architecture

### User Roles & Permissions

| Role | Description | Access Level | Features |
|------|-------------|--------------|----------|
| **Customer** | Regular users who can rent cars | Basic | - Browse cars<br>- Make bookings<br>- View profile<br>- Update personal info |
| **Staff** | Employees who manage operations | Admin | - All customer features<br>- Manage bookings<br>- View customer data<br>- Basic admin functions |
| **Manager** | Senior staff with full access | Super Admin | - All staff features<br>- User management<br>- System reports<br>- Settings management |

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   └── AuthController.php          # Main authentication controller
│   │   └── Admin/
│   │       └── AdminController.php         # Admin management controller
│   └── Middleware/
│       ├── AdminMiddleware.php             # Protects admin routes
│       └── ManagerMiddleware.php           # Protects manager routes
├── Models/
│   ├── User.php                            # User model with role relationships
│   └── Role.php                            # Role model
database/
├── migrations/
│   ├── 2024_01_01_000000_create_roles_table.php
│   └── 2024_01_01_000001_add_role_id_to_users_table.php
└── seeders/
    ├── RoleSeeder.php                      # Seeds default roles
    └── DatabaseSeeder.php                  # Seeds default users
resources/views/
├── auth/
│   ├── login.blade.php                     # Login form
│   ├── register.blade.php                  # Registration form
│   └── profile.blade.php                   # Profile management
├── admin/
│   └── dashboard.blade.php                 # Admin dashboard
└── dashboard.blade.php                     # Customer dashboard
routes/
└── web.php                                 # All authentication routes
```

## 🚀 Getting Started

### 1. Database Setup

Run the migrations and seeders to set up the database:

```bash
php artisan migrate:fresh --seed
```

This will create:
- Roles table with 3 default roles (customer, staff, manager)
- Users table with additional fields for car rental
- 3 default users for testing

### 2. Default Users

The system creates these default users for testing:

| Email | Password | Role | Description |
|-------|----------|------|-------------|
| `customer@example.com` | `password` | Customer | Test customer account |
| `staff@carrental.com` | `password` | Staff | Test staff account |
| `manager@carrental.com` | `password` | Manager | Test manager account |

## 🔐 Authentication Features

### User Registration
- **Customer Registration**: Full registration form with all required fields
- **Admin User Creation**: Staff/Managers can create users through admin panel
- **Validation**: Comprehensive validation for all user data
- **Driving License**: Required for customers with expiry validation

### User Login
- **Email/Password**: Standard email and password authentication
- **Remember Me**: Optional "remember me" functionality
- **Role-based Redirect**: Users are redirected based on their role
- **Account Status Check**: Inactive accounts cannot login

### Profile Management
- **Profile Updates**: Users can update personal information
- **Password Changes**: Secure password change functionality
- **Driving License Management**: License expiry tracking and warnings

## 🛡️ Security Features

### Middleware Protection
- **AdminMiddleware**: Protects admin routes (staff + managers)
- **ManagerMiddleware**: Protects manager-only routes
- **Auth Middleware**: Standard Laravel authentication protection

### Data Validation
- **Input Validation**: All user inputs are validated
- **Password Requirements**: Strong password requirements
- **Unique Constraints**: Email and driving license uniqueness
- **Date Validation**: License expiry date validation

### Account Security
- **Account Status**: Users can be activated/deactivated
- **Password Hashing**: Secure password storage
- **Session Management**: Proper session handling
- **CSRF Protection**: Built-in CSRF protection

## 🎯 User Interface

### Customer Interface
- **Dashboard**: Overview of account information
- **Profile Management**: Edit personal details
- **License Warnings**: Alerts for expiring licenses
- **Quick Actions**: Easy access to common functions

### Admin Interface
- **Statistics Dashboard**: User counts and system overview
- **User Management**: CRUD operations for all users
- **Role Management**: Assign and manage user roles
- **Account Control**: Activate/deactivate user accounts

### Responsive Design
- **Mobile Friendly**: Works on all device sizes
- **Bootstrap 5**: Modern, clean interface
- **FontAwesome Icons**: Professional iconography
- **Consistent Styling**: Matches car rental theme

## 🔧 API Endpoints

### Authentication Routes
```
GET    /login                    # Show login form
POST   /login                    # Handle login
GET    /register                 # Show registration form
POST   /register                 # Handle registration
POST   /logout                   # Handle logout
```

### Protected Routes
```
GET    /dashboard                # Customer dashboard
GET    /profile                  # User profile
PUT    /profile                  # Update profile
PUT    /profile/password         # Change password
```

### Admin Routes
```
GET    /admin/dashboard          # Admin dashboard
GET    /admin/users              # List all users
GET    /admin/users/create       # Create user form
POST   /admin/users              # Store new user
GET    /admin/users/{id}/edit    # Edit user form
PUT    /admin/users/{id}         # Update user
DELETE /admin/users/{id}         # Delete user
PATCH  /admin/users/{id}/toggle-status  # Toggle user status
PUT    /admin/users/{id}/reset-password  # Reset user password
```

## 🎨 Customization

### Adding New Roles
1. Add role to `RoleSeeder.php`
2. Update role checking methods in `User.php`
3. Create new middleware if needed
4. Update routes and views

### Modifying User Fields
1. Update migration files
2. Modify `User.php` model
3. Update validation rules in controllers
4. Update form views

### Styling Changes
- Modify CSS files in `public/assets/css/`
- Update Bootstrap classes in views
- Customize color scheme and branding

## 🧪 Testing

### Manual Testing
1. **Customer Flow**:
   - Register new customer account
   - Login and access dashboard
   - Update profile information
   - Change password

2. **Staff Flow**:
   - Login with staff account
   - Access admin dashboard
   - Manage users
   - View statistics

3. **Manager Flow**:
   - Login with manager account
   - Access all admin features
   - Create/edit/delete users
   - Manage system settings

### Security Testing
- Try accessing admin routes without authentication
- Attempt to access manager routes with staff account
- Test validation rules with invalid data
- Verify password requirements

## 📝 Notes

### Important Considerations
- **Driving License**: Required for customers, optional for staff/managers
- **Account Status**: Only active accounts can login
- **Role Hierarchy**: Manager > Staff > Customer
- **Data Integrity**: Foreign key constraints ensure data consistency

### Future Enhancements
- Email verification system
- Password reset functionality
- Two-factor authentication
- API authentication for mobile apps
- Advanced role permissions system
- Audit logging for admin actions

## 🆘 Troubleshooting

### Common Issues
1. **Migration Errors**: Ensure database is properly configured
2. **Role Issues**: Check if roles are seeded correctly
3. **Middleware Problems**: Verify middleware is registered in `bootstrap/app.php`
4. **Validation Errors**: Check validation rules in controllers

### Debug Commands
```bash
# Check database tables
php artisan migrate:status

# Recreate database
php artisan migrate:fresh --seed

# Clear cache
php artisan config:clear
php artisan cache:clear

# Check routes
php artisan route:list
```

---

**Created by**: Carola Car Rental Development Team  
**Last Updated**: January 2024  
**Version**: 1.0.0 