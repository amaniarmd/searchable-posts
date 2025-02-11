<?php

namespace App\Enumerations\ElasticSearch;

enum Fields: string
{
    case INDEX = 'index';
    case UNDERLINE_INDEX = '_index';
    case UNDERLINE_ID = '_id';
    case UNDERLINE_SOURCE = '_source';
    case OPERATOR = 'operator';
    case AND_OPERATOR = 'and';
    case FROM = 'from';
    case SIZE = 'size';
    case SORT = 'sort';
    case ORDER = 'order';
    case BODY = 'body';
    case QUERY = 'query';
    case HITS = 'hits';
    case TOTAL = 'total';
    case VALUE = 'value';
    case MULTI_MATCH = 'multi_match';
    case FIELDS = 'fields';
    case DOC = 'doc';
    case POST_CATEGORY = 'category';
    case POSTS_INDEX_NAME = 'posts';
    case ENV_KEY_HOST = 'ELASTICSEARCH_HOST';
    case ENV_KEY_PORT = 'ELASTICSEARCH_PORT';
    case ENV_KEY_PASSWORD = 'ELASTICSEARCH_PASSWORD';
    case DEFAULT_ELASTIC_USERNAME = 'elastic';
    case ENV_DEFAULT_HOST = 'http://127.0.0.1:9200';
}
