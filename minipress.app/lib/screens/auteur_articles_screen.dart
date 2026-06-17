import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../providers/article_provider.dart';
import '../widget/article_tile.dart';

class AuteurArticlesScreen extends StatelessWidget {
  final String author;

  const AuteurArticlesScreen({super.key, required this.author});

  @override
  Widget build(BuildContext context) {
    final provider = Provider.of<ArticleProvider>(context);

    final articles = provider.getArticlesByAuthor(author);

    return Scaffold(
      appBar: AppBar(title: Text("Articles de $author")),
      body: articles.isEmpty
          ? const Center(child: Text("Aucun article trouvé"))
          : ListView.builder(
              itemCount: articles.length,
              itemBuilder: (context, index) {
                return ArticleTile(
                  article: articles[index],
                  enableAuthorNavigation: false,
                );
              },
            ),
    );
  }
}
