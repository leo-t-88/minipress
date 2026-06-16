import 'package:flutter/material.dart';
import '../models/article.dart';
import '../screens/article_detail_screen.dart';

class ArticleTile extends StatelessWidget {
  final Article article;

  const ArticleTile({super.key, required this.article});

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 0,
      color: Colors.transparent,
      child: InkWell(
        onTap: () => Navigator.push(context, MaterialPageRoute(builder: (_) => ArticleDetailScreen(article: article)),),
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
                title: Text(article.title, style: TextStyle(fontWeight: FontWeight.bold, color: Theme.of(context).colorScheme.primary,),),
                subtitle: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text("Créé le : ${article.createdAt}"),
                    GestureDetector(
                      behavior: HitTestBehavior.opaque,
                      onTap: () {
                        //To do Fonctionnalité 5 : Articles de l'auteur
                      },
                      child: Text("Auteur : ${article.author}",),
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
