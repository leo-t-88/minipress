import 'package:flutter/material.dart';
import '../models/article.dart';
import '../screens/article_detail_screen.dart';
import '../screens/auteur_articles_screen.dart';

class ArticleTile extends StatelessWidget {
  final Article article;
  final bool enableAuthorNavigation;

  const ArticleTile({
    super.key,
    required this.article,
    this.enableAuthorNavigation = true,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.all(7),
      elevation: 0,
      color: Colors.transparent,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: InkWell(
        borderRadius: BorderRadius.circular(10),
        highlightColor: Colors.transparent,
        onTap: () => Navigator.push(
          context,
          MaterialPageRoute(
            builder: (_) => ArticleDetailScreen(article: article),
          ),
        ),
        child: Container(
          decoration: BoxDecoration(
            color: Theme.of(context).colorScheme.primary.withOpacity(0.1),
            borderRadius: BorderRadius.circular(10),
          ),
          padding: const EdgeInsets.all(12),
          child: Row(
            children: [
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      article.title,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: Theme.of(context).colorScheme.primary,
                      ),
                    ),

                    const SizedBox(height: 4),

                    Text("Créé le : ${article.createdAt}"),

                    GestureDetector(
                      behavior: HitTestBehavior.opaque,

                      onTap: enableAuthorNavigation
                          ? () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (_) => AuteurArticlesScreen(
                                    author: article.author,
                                  ),
                                ),
                              );
                            }
                          : null,

                      child: Text(
                        "Auteur : ${article.author}",
                        style: TextStyle(
                          color: const Color.fromARGB(255, 130, 162, 75),
                          decoration: enableAuthorNavigation ? TextDecoration.underline : TextDecoration.none,
                        ),
                      ),
                    ),
                  ],
                ),
              ),

              const Icon(Icons.chevron_right),
            ],
          ),
        ),
      ),
    );
  }
}
