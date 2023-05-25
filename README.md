# Embedditor

<p align="center">
  <img width="300" height="300" src="https://embedditor.ingestai.co/images/logo.jpg">

</p>

# <center>Get the most out of your vector search</center>

Embedditor is an open source embedding pre-reprocessing editor, that helps you edit GPT / LLM embeddings just as if it's a Microsoft Word document, so you can get the most out of your vector search, while significanty reducing costs of embedding and vector storage.



# Features
**Rich editor Interface**

- ⚡ Join and split one or multiple chunks with a few clicks
- ⚡ Edit embedding metadata and tokens
- ⚡ Exclude words, sentences, or even parts of chunks from embedding
- ⚡ Select the parts of chunk you want to be embedded
- ⚡ Add additional information to your mebeddings, like url links or images
- ⚡ Get a nice looking HTML-markup for your AI search results
- ⚡ Save your pre-processed embedding files in .veml or .jason formats

**Pre-processing automation**
- ⚡ Filteer our from vectorization most of the 'noise', like punctuations or stop-words
- ⚡ Remove from embedidng unsignificant, requently used words with TF-IDF algorithm
- ⚡ Normalize your embedding tokens before vectorization

# Benefits
**Rich Spreadsheet Interface**

- ⚡ Optimized relevance of the content retrieved from a vector database
- ⚡ Improved efficiency and accuracy in your AI / LLM-related applications
- ⚡ Visually better looking search results with images, url links, etc
- ⚡ Increased cost-efficiency with up to 30% cost-reduction on embedding and vector storage
- ⚡ Full control over your data, effortlessly deploying Embedditor locally on your PC or dedicated envirement
- ⚡ Save your pre-processed or ready embeddings in .json or .veml format to use it in LangChain, Chromat or any other Vector DB


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
