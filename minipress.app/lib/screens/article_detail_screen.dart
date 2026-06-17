import 'package:flutter/material.dart';
import 'package:flutter_markdown/flutter_markdown.dart';
import '../models/article.dart';
import '../services/api_service.dart';

class ArticleDetailScreen extends StatefulWidget {
  final Article article;

  const ArticleDetailScreen({super.key, required this.article});

  @override
  State<ArticleDetailScreen> createState() => _ArticleDetailScreenState();
}

class _ArticleDetailScreenState extends State<ArticleDetailScreen> {
  Article? fullArticle;
  bool loading = true;

  @override
  void initState() {
    super.initState();
    _load();
  }

  Future<void> _load() async {
    final service = ApiService();
    final a = await service.fetchArticleById(widget.article.apiUrl!);
    setState(() {
      fullArticle = a;
      loading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.article.title),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () => Navigator.pop(context),
        ),
      ),

      body: loading ? const Center(child: CircularProgressIndicator()) : Padding(
        padding: const EdgeInsets.all(16),
        child: ListView(
          children: [
            Text(fullArticle!.title, style: Theme.of(context).textTheme.headlineSmall,),
            const SizedBox(height: 8),
            Text("Publié le : ${fullArticle!.publishedAt}"),

            const SizedBox(height: 20),

            MarkdownBody(
              data: fullArticle!.content ?? "",
              selectable: true,
              styleSheet: MarkdownStyleSheet(
                p: Theme.of(context).textTheme.bodyMedium,
              ),
            ),

            if (fullArticle!.resume != null) Container(
              padding: const EdgeInsets.all(7),
              decoration: BoxDecoration(
                color: Theme.of(context).colorScheme.primary.withOpacity(0.1),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text("Résumé"),
                  MarkdownBody(
                    data: fullArticle!.resume!,
                    selectable: true,
                    styleSheet: MarkdownStyleSheet(
                      p: Theme.of(context).textTheme.bodyMedium,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
