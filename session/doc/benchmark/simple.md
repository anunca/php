# simple benchmark
## 1. Filesystem
```sh
This is ApacheBench, Version 2.3 <$Revision: 1913912 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        Apache/2.4.58
Server Hostname:        localhost
Server Port:            80

Document Path:          /
Document Length:        89 bytes

Concurrency Level:      10
Time taken for tests:   40.575 seconds
Complete requests:      10000
Failed requests:        1573
   (Connect: 0, Receive: 0, Length: 1573, Exceptions: 0)
Total transferred:      4338455 bytes
HTML transferred:       888455 bytes
Requests per second:    246.46 [#/sec] (mean)
Time per request:       40.575 [ms] (mean)
Time per request:       4.057 [ms] (mean, across all concurrent requests)
Transfer rate:          104.42 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.1      0       5
Processing:     7   40  78.1     27    1517
Waiting:        6   39  78.0     26    1516
Total:          7   40  78.1     27    1517

Percentage of the requests served within a certain time (ms)
  50%     27
  66%     32
  75%     36
  80%     40
  90%     59
  95%     83
  98%    128
  99%    207
 100%   1517 (longest request)
```
## 2. Memcached
```sh
This is ApacheBench, Version 2.3 <$Revision: 1913912 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        Apache/2.4.58
Server Hostname:        localhost
Server Port:            80

Document Path:          /
Document Length:        447 bytes

Concurrency Level:      10
Time taken for tests:   66.601 seconds
Complete requests:      10000
Failed requests:        1012
   (Connect: 0, Receive: 0, Length: 1012, Exceptions: 0)
Total transferred:      7918866 bytes
HTML transferred:       4468866 bytes
Requests per second:    150.15 [#/sec] (mean)
Time per request:       66.601 [ms] (mean)
Time per request:       6.660 [ms] (mean, across all concurrent requests)
Transfer rate:          116.11 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.3      0      18
Processing:    31   66  11.5     64     194
Waiting:       31   66  11.4     64     194
Total:         31   66  11.5     64     194

Percentage of the requests served within a certain time (ms)
  50%     64
  66%     67
  75%     69
  80%     71
  90%     77
  95%     85
  98%    102
  99%    112
 100%    194 (longest request)
```
## 3. Redis
```sh
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        Apache/2.4.62
Server Hostname:        localhost
Server Port:            80

Document Path:          /
Document Length:        32 bytes

Concurrency Level:      10
Time taken for tests:   2.119 seconds
Complete requests:      10000
Failed requests:        0
Total transferred:      3770000 bytes
HTML transferred:       320000 bytes
Requests per second:    4719.90 [#/sec] (mean)
Time per request:       2.119 [ms] (mean)
Time per request:       0.212 [ms] (mean, across all concurrent requests)
Transfer rate:          1737.70 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       0
Processing:     1    2   0.6      2      11
Waiting:        1    2   0.6      2      11
Total:          1    2   0.6      2      11

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      3
  95%      3
  98%      4
  99%      5
 100%     11 (longest request)
```
## 4. Dragonfly
```sh
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        Apache/2.4.62
Server Hostname:        localhost
Server Port:            80

Document Path:          /
Document Length:        32 bytes

Concurrency Level:      10
Time taken for tests:   3.357 seconds
Complete requests:      10000
Failed requests:        0
Total transferred:      3770000 bytes
HTML transferred:       320000 bytes
Requests per second:    2979.18 [#/sec] (mean)
Time per request:       3.357 [ms] (mean)
Time per request:       0.336 [ms] (mean, across all concurrent requests)
Transfer rate:          1096.83 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       0
Processing:     1    3   1.1      3      30
Waiting:        1    3   1.1      3      30
Total:          1    3   1.1      3      30

Percentage of the requests served within a certain time (ms)
  50%      3
  66%      4
  75%      4
  80%      4
  90%      4
  95%      4
  98%      5
  99%      7
 100%     30 (longest request)
```
## 5. Valkey
```sh
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking localhost (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        Apache/2.4.62
Server Hostname:        localhost
Server Port:            80

Document Path:          /
Document Length:        32 bytes

Concurrency Level:      10
Time taken for tests:   2.352 seconds
Complete requests:      10000
Failed requests:        0
Total transferred:      3770000 bytes
HTML transferred:       320000 bytes
Requests per second:    4252.14 [#/sec] (mean)
Time per request:       2.352 [ms] (mean)
Time per request:       0.235 [ms] (mean, across all concurrent requests)
Transfer rate:          1565.49 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       0
Processing:     1    2   0.8      2      13
Waiting:        1    2   0.8      2      13
Total:          1    2   0.8      2      13

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      3
  80%      3
  90%      3
  95%      3
  98%      4
  99%      6
 100%     13 (longest request)
```