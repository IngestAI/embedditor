# Embedditor

<p align="center">
  <img width="300" height="300" src="https://embedditor.ingestai.co/images/logo.jpg">
</p>



## Get the most out of your vector search

Embedditor is an open source editor that helps you edit GPT / LLM embeddings just as if it's a Microsoft Word document, so you can get the most out of your vector search, while significanty reducing costs of embedding and vector storage.

# Features
**Rich Spreadsheet Interface**

- ⚡ **Join and split one or multiple chunks with a few clicks
- ⚡ **Exclude words, sentences, or even parts of chunks from embedding
- ⚡ **Select the parts of chunk you want to be embedded
- ⚡ **Add additional information to your mebeddings, like url links or images
- ⚡ **Get a nice looking HTML-markup for your AI search results
- ⚡ **Filteer our from vectorization most of the 'noise' like punctuations or stop-words
- ⚡ **Save your pre-processed embedding files in .veml or .jason formats

### Embed like a pro

Work on your embedding metadata and tokens with a user-friendly UI. Seamlessly cleanse, normalize, and enrich your embedding tokens, improving efficiency and accuracy in your LLM-related applications.

### Uplevel your vector search

Optimize the relevance of the content you get back from a vector database, intelligently splitting or merging the content based on its structure and adding void or hidden tokens, making chunks even more semantically coherent.

### Automate with NLP algorithms

Apply TF-IDF model with one click to determine unsignificant words in your documents and filter their tokens out of embedding to get even better vector search results and save on vector storage.

### Get the full control over your data

Get the full control over your data effortlessly deploying Embedditor locally on your PC or in your dedicated enterprise cloud or on-premises environment.

### Reduce your costs

Applying Embedditor cleansing of irrelevant tokens like stop-words, punctuations, and low-relevant words you can save up to 70% on the cost of vector storage and embedding.


### Use it anywhere

Save your processed embedding metadata and tokens in .embs or json to share it with your team, use it in LangChain, or upload to any vector database, like Chroma.


## Quick try
**Sign up for free and try it in [IngestAI](https://ingestai.io/signup).**

<!-- # Rich Spreadsheet Interface

- ⚡ **Basic Operations**: Create, Read, Update and Delete Tables, Columns, and Rows
- ⚡ **Fields Operations**: Sort, Filter, Hide / Unhide Columns
- ⚡ **Multiple Views Types**: Grid (By default), Gallery, Form View, and Kanban View
- ⚡ **View Permissions Types**: Collaborative Views, & Locked Views
- ⚡ **Share Bases / Views**: either Public or Private (with Password Protected)
- ⚡ **Variant Cell Types**: ID, LinkToAnotherRecord, Lookup, Rollup, SingleLineText, Attachment, Currency, Formula, etc
- ⚡ **Access Control with Roles**: Fine-grained Access Control at different levels
- ⚡ **and more** -->

<!-- ### FAQ

**What is embedding (vectorization)?**

**What are embeddings?**

**What is vector search?**

**What is embeddings metadata?**

**What is embedding tokens?**

**What is void embedding tokens?**
A void (embedding) tokens are words in your content (embedding metadata), that will appear in your vector search results but are filtered out of embedding and so won’t be found with vector search.

**What is hidden embedding token?**
A hidden embedding token is a token that will be embedded for vector storage but doesn’t appear in your metadata – the content you will retrieve using vector search.

**What size have embeddings?**
Embedding your content to vector space increases its size, requiring up to 10X of storage space than your row content. That is why filtering out unnecessary and low-relevant tokens not only improves your vector search but also helps you reduce cost of embedding and storage. -->


### Installation

1. Copy .env.example into .env

2. Set the following settings in the .env


    `OPENAI_API_KEY=`


3. Setup the project

- `php artisan migrate`
- `php artisan db:seed`
