## 2. Memcached
Memcached is a high-performance, distributed memory object caching system, which can be used to store session data in memory for fast access.
### Implementation
1. In `php.ini`:
    ```ini
    session.save_handler = memcached
    session.save_path = "localhost:11211"
    ```
3. In your PHP script:
    ```php
    <?php
    session_start();
    $_SESSION['key'] = 'value';
    echo $_SESSION['key'];
    ?>
    ```
### Benefits
- **Performance**: Very fast as data is stored in memory.
- **Scalability**: Suitable for distributed systems, can be scaled horizontally.
### Drawbacks
- **Volatility**: Data is stored in memory, so it's lost if the server restarts.
- **Complexity**: Requires additional setup and maintenance.