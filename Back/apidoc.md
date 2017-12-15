<a name="top"></a>
# Front_Back v0.1.0

apiDoc

- [AllArticles](#allarticles)
  - [Insert a new Article](#insert-a-new-article)
  - [Request all articles](#request-all-articles)
  - [Request all articles with their paragraphs](#request-all-articles-with-their-paragraphs)
  
- [AllParagraphs](#allparagraphs)
  - [request all paragraphs](#request-all-paragraphs)
  
- [Article](#article)
  - [Delete an article](#delete-an-article)
  - [request Article information](#request-article-information)
  - [Modify an article](#modify-an-article)
  
- [Paragraph](#paragraph)
  - [Add a new paragraph of the article](#add-a-new-paragraph-of-the-article)
  - [Delete a paragraph](#delete-a-paragraph)
  - [Get the pos-ian paragraph of the article](#get-the-pos-ian-paragraph-of-the-article)
  - [Modify a paragraph](#modify-a-paragraph)
  
- [Paragraphs](#paragraphs)
  - [Request all paragraphs of the article](#request-all-paragraphs-of-the-article)
  


# AllArticles

## Insert a new Article
[Back to top](#top)



  POST /api/v1/articles





### Parameter Parameters

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| TITLE | String | <p>The Title of article to create</p>|

### Success Response

Success-Response:

```
HTTP/1.1 201 OK
{
    "ID": 1,
    "TITLE" : "Lorem Ipsum"
}
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article created</p>|
| TITLE | String | <p>Title of the article created</p>|




## Request all articles
[Back to top](#top)



  GET /api/v1/articles




### Success Response

Success-Response:

```
HTTP/1.1 200 OK
[
    {
        "ID": 1,
        "TITLE" : "Lorem Ipsum"
    },
    {
        "ID": 2,
        "TITLE" : "The game"
    },
    ...
]
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article</p>|
| TITLE | String | <p>Title of the article</p>|




## Request all articles with their paragraphs
[Back to top](#top)



  GET /api/v1/articles?paragraphs=true




### Success Response

Success-Response:

```
HTTP/1.1 200 OK
[
    {
        "ID": 1,
        "TITLE" : "Lorem Ipsum",
        "CONTENT": [
                {
                    "ID": 1,
                    "CONTENT": "Lorem ipsum dolor sit amet.",
                    "POSITION": 1,
                    "ARTICLE_ID": 1
                },
                {
                    "ID": 2,
                    "CONTENT": "Ut enim ad minim veniam.",
                    "POSITION": 2,
                    "ARTICLE_ID": 1
                },
                ...
    },
    {
        "ID": 2,
        "TITLE" : "The game",
        "CONTENT" : [
                {
                    "ID": 3,
                    "CONTENT": "Perdu !",
                    "POSITION": 1,
                    "ARTICLE_ID": 2
                },
                ...
    },
    ...
]
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article</p>|
| TITLE | String | <p>Title of the article</p>|
| CONTENT | Object[] | <p>List of paragraphs</p>|
| CONTENT.ID | Number | <p>Id of the article patched</p>|
| CONTENT.TITLE | String | <p>Title of the article patched</p>|
| CONTENT.POSITION | Number | <p>The position of the paragraph in the article</p>|
| CONTENT.ARTICLE_ID | Number | <p>The Id of the article associated to the paragraph</p>|




# AllParagraphs

## request all paragraphs
[Back to top](#top)



  GET /api/v1/paragraphs




### Success Response

Success-Response:

```
HTTP/1.1 200 OK
[
    {
        "ID": 1,
        "CONTENT": "Lorem ipsum dolor sit amet.",
        "POSITION": 1,
        "ARTICLE_ID": 1
    },
    {
        "ID": 2,
        "CONTENT": "Ut enim ad minim veniam.",
        "POSITION": 2,
        "ARTICLE_ID": 1
    },
    ...
]
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the paragraph</p>|
| CONTENT | String | <p>Content of the article</p>|
| POSITION | Number | <p>The position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>The Id of the article associated to the paragraph</p>|




# Article

## Delete an article
[Back to top](#top)



  DELETE /api/v1/articles/:id




### Success Response

201 Success-Response:

```
HTTP/1.1 201 OK
{
    "Response: "Successfully deleted article with ID <code>ID</code>",
}
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the deleted article</p>|


### Error 4xx

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ArticleNotFound |  | <p>No article with the ID <code>ID</code> found</p>|


### Error Response

Error-Response:

```
HTTP/1.1 404 Not Found
    {
        "Error": "No article with the ID <code>ID</code> found"
    }
```
## request Article information
[Back to top](#top)



  GET /api/v1/articles/:id




### Success Response

Success-Response:

```
HTTP/1.1 201 OK
{
    "ID": 1,
    "TITLE" : "Lorem Ipsum"
}
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article</p>|
| TITLE | String | <p>Title of the article</p>|


### Error 4xx

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ArticleNotFound |  | <p>No article with the ID <code>ID</code> found</p>|


## Modify an article
[Back to top](#top)



  PATCH /api/v1/articles/:id





### Parameter Parameters

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| TITLE | String | <p>The Title of article to patch</p>|

### Success Response

Success-Response:

```
HTTP/1.1 201 OK
{
    "ID": 1,
    "TITLE" : "Lorem Ipsum"
}
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article patched</p>|
| TITLE | String | <p>Title of the article patched</p>|




# Paragraph

## Add a new paragraph of the article
[Back to top](#top)



  POST /api/v1/articles/:idA/paragraphs





### Parameter Parameters

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Optional Id of the paragraph patched</p>|
| CONTENT | String | <p>Optional Content of the paragraph patched</p>|
| POSITION | Number | <p>Optional position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>Optional Id of the article associated to the paragraph</p>|

### Success Response

Success-Response:

```
HTTP/1.1 201 OK
    [
        {
            "ID": 2,
            "CONTENT": "Ut enim ad minim veniam.",
            "POSITION": 2,
            "ARTICLE_ID": 1
        },
        ...
    ]
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article patched</p>|
| TITLE | String | <p>Title of the article patched</p>|
| POSITION | Number | <p>The position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>The Id of the article associated to the paragraph</p>|




## Delete a paragraph
[Back to top](#top)



  DELETE /api/v1/paragraphs/:id




### Success Response

201 Success-Response:

```
HTTP/1.1 201 OK
{
    "Response: "Successfully deleted paragraph with ID <code>ID</code>",
}
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the deleted paragraph</p>|


### Error 4xx

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ArticleNotFound |  | <p>No paragraph with the ID <code>ID</code> found</p>|


### Error Response

Error-Response:

```
HTTP/1.1 404 Not Found
    {
        "Error": "No paragraph with the ID <code>ID</code> found"
    }
```
## Get the pos-ian paragraph of the article
[Back to top](#top)



  GET /api/v1/articles/:idA/paragraphs/:pos




### Success Response

Success-Response:

```
HTTP/1.1 201 OK
    [
        {
            "ID": 2,
            "CONTENT": "Ut enim ad minim veniam.",
            "POSITION": 2,
            "ARTICLE_ID": 1
        },
        ...
    ]
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article patched</p>|
| TITLE | String | <p>Title of the article patched</p>|
| POSITION | Number | <p>The position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>The Id of the article associated to the paragraph</p>|




## Modify a paragraph
[Back to top](#top)



  PATCH /api/v1/paragraphs/:id





### Parameter Parameters

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Optional Id of the paragraph patched</p>|
| CONTENT | String | <p>Optional Content of the paragraph patched</p>|
| POSITION | Number | <p>Optional position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>Optional Id of the article associated to the paragraph</p>|

### Success Response

Success-Response:

```
HTTP/1.1 201 OK
    {
        "ID": 2,
        "CONTENT": "Ut enim ad minim veniam.",
        "POSITION": 2,
        "ARTICLE_ID": 1
    }
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article patched</p>|
| TITLE | String | <p>Title of the article patched</p>|
| POSITION | Number | <p>The position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>The Id of the article associated to the paragraph</p>|




# Paragraphs

## Request all paragraphs of the article
[Back to top](#top)



  GET /api/v1/articles/:idA/paragraphs




### Success Response

Success-Response:

```
HTTP/1.1 201 OK
    [
        {
            "ID": 2,
            "CONTENT": "Ut enim ad minim veniam.",
            "POSITION": 2,
            "ARTICLE_ID": 1
        },
        ...
    ]
```

### Success 200

| Name     | Type       | Description                           |
|:---------|:-----------|:--------------------------------------|
| ID | Number | <p>Id of the article patched</p>|
| TITLE | String | <p>Title of the article patched</p>|
| POSITION | Number | <p>The position of the paragraph in the article</p>|
| ARTICLE_ID | Number | <p>The Id of the article associated to the paragraph</p>|




