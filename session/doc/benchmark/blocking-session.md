# blocking session
## 1. Filesystem
```sh
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient).....done


Server Software:        Apache/2.4.62
Server Hostname:        localhost
Server Port:            80

Document Path:          /benchmark/blocking.php
Document Length:        0 bytes

Concurrency Level:      5
Time taken for tests:   20.012 seconds
Complete requests:      10
Failed requests:        0
Total transferred:      3000 bytes
HTML transferred:       0 bytes
Requests per second:    0.50 [#/sec] (mean)
Time per request:       10006.140 [ms] (mean)
Time per request:       2001.228 [ms] (mean, across all concurrent requests)
Transfer rate:          0.15 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       0
Processing:  2002 7204 3426.3  10004   10006
Waiting:     2002 7204 3426.3  10004   10006
Total:       2002 7204 3426.3  10004   10006

Percentage of the requests served within a certain time (ms)
  50%  10004
  66%  10004
  75%  10005
  80%  10005
  90%  10006
  95%  10006
  98%  10006
  99%  10006
 100%  10006 (longest request)
```
## 2. Redis
```sh
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient).....done


Server Software:        Apache/2.4.62
Server Hostname:        localhost
Server Port:            80

Document Path:          /benchmark/blocking.php
Document Length:        0 bytes

Concurrency Level:      5
Time taken for tests:   7.009 seconds
Complete requests:      10
Failed requests:        0
Total transferred:      1900 bytes
HTML transferred:       0 bytes
Requests per second:    1.43 [#/sec] (mean)
Time per request:       3504.559 [ms] (mean)
Time per request:       700.912 [ms] (mean, across all concurrent requests)
Transfer rate:          0.26 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.1      0       0
Processing:  2002 2303 674.3   2004    4002
Waiting:     2002 2303 674.4   2003    4002
Total:       2003 2303 674.3   2004    4002

Percentage of the requests served within a certain time (ms)
  50%   2004
  66%   2004
  75%   2004
  80%   3002
  90%   4002
  95%   4002
  98%   4002
  99%   4002
 100%   4002 (longest request)
```