1. Introduction
Stock photo search engine demonstration.

2. Technology Stack
   Nginx,PHP-FPM, Drupal 7, MySQL, MongoDB, Apache Solr, Memcached, Redis
   Crawling: SimpleHTMLDom
   - Start Solr 5.x with docker
   docker run -id -p host-ip:8985:8983 -v /opt/my-solr/:/opt/solr/server/solr/drupal/data -t mxr576/apachesolr-5.x-drupal-docker
   - 
3. How it works


