1. Introduction
Stock photo search engine demonstration.

2. Technology Stack
   Nginx,PHP-FPM, Drupal 7, MySQL, MongoDB, Apache Solr, Memcached, Redis
   Crawling: SimpleHTMLDom
  
3. How to install
-Install simple LAMP, LEMP stack then get source code with following command

 $git clone https://github.com/thuannvn/stock-demo 

-Restore Db in backup/stock-demo.sql into your MySQL

-Then start your webserver (apache PHP or Nginx PHP-PFM)
 Search API: http://stock-demo.techblogsearch.com/search-api.php ( http://stock-demo.techblogsearch.com/search-api.php?q=sunday)
 Photo Detail: http://stock-demo.techblogsearch.com/node/595
 Solr UlR: http://host-ip:8984/core0



