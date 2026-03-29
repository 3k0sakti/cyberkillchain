# VulnWeb - Intentionally Vulnerable Web Application

**VulnWeb**is an intentionally vulnerable web application built for cybersecurity education and training, specifically for practicing the**Cyber Kill Chain**methodology.

## WARNING

**This application is intentionally dangerous and must only be used for educational purposes in a controlled environment. DO NOT deploy on production systems or public networks!**

## Quick Start

### Running with Docker

1. Clone or download this application
2. Make sure Docker and Docker Compose are installed
3. Run the following commands:

```bash
# Build and start the application
docker-compose up -d

# Access the app in your browser
http://localhost:8080
```

### Test Accounts

| Username | Password | Role |
|----------|----------|------|
| admin | admin123 | Administrator |
| user1 | password123 | User |
| user2 | mypassword | User |
| moderator | mod123 | Moderator |

## Available Vulnerabilities

### 1. SQL Injection
-**Location**: Login form, product search, orders page
-**Impact**: Authentication bypass, data extraction, privilege escalation
-**Testing**: `' OR '1'='1`, `' UNION SELECT ...`

### 2. Cross-Site Scripting (XSS)
-**Location**: Comment system, profile updates
-**Impact**: Session hijacking, credential theft
-**Testing**: `<script>alert('XSS')</script>`, `<img src=x onerror=alert('XSS')>`

### 3. Broken Authentication
-**Vulnerabilities**: Weak passwords, predictable sessions, no account lockout
-**Impact**: Account takeover, unauthorized access
-**Testing**: Brute force, session prediction

### 4. Broken Access Control
-**Vulnerabilities**: IDOR, privilege escalation, missing authorization
-**Impact**: Unauthorized data access, privilege escalation
-**Testing**: URL manipulation, parameter tampering

## Cyber Kill Chain Implementation

### Phase 1: Reconnaissance
- Port scanning and technology fingerprinting
- Directory enumeration
- Information gathering via debug mode (`?debug=1`)

### Phase 2: Weaponization
- Crafting SQL injection payloads
- Creating XSS payloads
- Preparing privilege escalation exploits

### Phase 3: Delivery
- Injection via the login form
- XSS through the comment system
- Parameter manipulation in URLs

### Phase 4: Exploitation
- SQL injection execution
- XSS payload execution
- Authentication bypass
- IDOR exploitation

### Phase 5: Installation
- Creating persistent XSS
- Injecting admin accounts
- Session fixation

### Phase 6: Command & Control
- Accessing the admin panel
- Using the SQL console
- User management

### Phase 7: Actions on Objectives
- Data exfiltration
- Account manipulation
- System compromise

## Struktur Aplikasi

```
vulnweb/
 docker-compose.yml          # Docker orchestration
 Dockerfile                  # Container definition
 apache-config.conf          # Apache configuration
 database/
    init.sql               # Database initialization
 src/
     config.php             # Database & core functions
     header.php             # Common header
     footer.php             # Common footer
     index.php              # Homepage
     login.php              # Login system (SQL injection)
     register.php           # Registration (privilege escalation)
     products.php           # Product listing (SQL injection)
     comments.php           # Comment system (XSS)
     orders.php             # Order management (broken access control)
     admin.php              # Admin panel (multiple vulnerabilities)
     profile.php            # User profile
     logout.php             # Logout functionality
     vulnerabilities.php    # Vulnerability guide
```

## Testing Tools

### Recommended Tools:
-**Burp Suite**: Web application security testing
-**OWASP ZAP**: Automated vulnerability scanning
-**sqlmap**: Automated SQL injection testing
-**XSSHunter**: XSS testing platform
-**Nikto**: Web server scanner

### Manual Testing:
1. Access `http://localhost:8080?debug=1` for debug mode
2. Test SQL injection on the login form and search
3. Test XSS in the comment system
4. Test IDOR by modifying URL parameters
5. Test privilege escalation during registration

## Learning Objectives

After using VulnWeb, students should be able to:

1.**Understand the Cyber Kill Chain**: Apply all 7 phases in the context of web application security
2.**Identify Vulnerabilities**: Recognize various types of web vulnerabilities
3.**Exploitation Techniques**: Practice common exploitation techniques
4.**Impact Assessment**: Understand the impact of each vulnerability
5.**Mitigation Strategies**: Develop prevention and remediation strategies

## Lab Scenarios

### Scenario 1: Information Gathering
- Perform reconnaissance to identify technologies in use
- Find vulnerable endpoints and parameters
- Document your findings

### Scenario 2: Authentication Bypass
- Bypass the authentication system using SQL injection
- Access the admin account without knowing the password
- Document each step of the exploit

### Scenario 3: Data Extraction
- Extract sensitive data from the database
- Find other users' passwords
- Document the data successfully retrieved

### Scenario 4: Privilege Escalation
- Escalate privileges from a regular user to admin
- Access administrative functions
- Document the method used

### Scenario 5: Persistent Attack
- Create a persistent XSS to steal cookies
- Maintain access using a backdoor
- Document the persistence mechanism

## Defensive Measures

As part of the learning process, identify and implement:

1.**Input Validation**: Proper sanitization and validation
2.**Output Encoding**: Escape output to prevent XSS
3.**Authentication**: Strong password policy, secure session management
4.**Authorization**: Proper access control implementation
5.**Error Handling**: Secure, non-verbose error messages
6.**Security Headers**: CSP, X-Frame-Options, etc.

## Assessment Criteria

Grading is based on:

1.**Technical Skills**(40%):
   - Ability to identify vulnerabilities
   - Exploitation techniques used
   - Tools and methodology

2.**Documentation**(30%):
   - Clear and detailed report
   - Screenshots and proof of concept
   - Risk assessment

3.**Understanding**(20%):
   - Understanding of the Cyber Kill Chain
   - Impact analysis
   - Mitigation recommendations

4.**Methodology**(10%):
   - Systematic approach
   - Ethical considerations
   - Professional conduct

## Support

For questions or assistance:
- Open an issue in this repository
- Consult with your instructor
- Discuss in the class forum

## License

This application was built for educational purposes. Use it responsibly.

---

**Good luck and enjoy the Cyber Kill Chain lab!**