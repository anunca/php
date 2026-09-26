## 1. Filesystem
By default, PHP stores session data in files on the server's filesystem. This method is simple to set up and works well for small applications.
### Implementation
1. In `php.ini`:
    ```ini
    session.save_handler = files
    session.save_path = "/path/to/sessions"
    ```
2. In your PHP script:
    ```php
    <?php
    session_start();
    $_SESSION['key'] = 'value';
    echo $_SESSION['key'];
    ?>
    ```
### Benefits
- **Simplicity**: Easy to set up and requires no additional extensions.
- **Compatibility**: Works out of the box with PHP.
### Drawbacks
- **Performance**: Can be slow for large-scale applications due to disk I/O.
- **Scalability**: Not suitable for distributed systems without shared storage.