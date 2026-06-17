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
      elevation: 0,
      color: Colors.transparent,
      child: InkWell(
        onTap: () => Navigator.push(
          context,
          MaterialPageRoute(
            builder: (_) => ArticleDetailScreen(article: article),
          ),
        ),
        child: Row(
          children: [
            Container(
              width: 5,
              height: 60,
              decoration: BoxDecoration(
                color: Theme.of(context).colorScheme.primary,
                borderRadius: const BorderRadius.all(Radius.circular(4)),
              ),
            ),

            Expanded(
              child: ListTile(
                title: Text(
                  article.title,
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    color: Theme.of(context).colorScheme.primary,
                  ),
                ),
                subtitle: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
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
                      child: Text("Auteur : ${article.author}", style: TextStyle(color: const Color.fromARGB(255, 184, 249, 72))),
                    ),
                  ],
                ),
                trailing: const Icon(Icons.chevron_right),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
