import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../widget/article_tile.dart';
import '../providers/article_provider.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<ArticleProvider>();

    return Scaffold(
      appBar: AppBar(
        title: const Text("MiniPress"),
        bottom: PreferredSize(
          preferredSize: const Size.fromHeight(100),
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 4.0),
            child: Column(
              children: [
                TextField(
                  decoration: InputDecoration(
                    hintText: "Rechercher",
                    prefixIcon: const Icon(Icons.search),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(25.0),
                      borderSide: BorderSide.none,
                    ),
                    filled: true,
                    contentPadding: const EdgeInsets.symmetric(vertical: 0),
                  ),
                  onChanged: (value) {
                    context.read<ArticleProvider>().setSearchQuery(value);
                  },
                ),
                const SizedBox(height: 5),
                Align(
                  alignment: Alignment.centerLeft,
                  child: ActionChip(
                    label: Text(provider.sortAscending ? "Ancien" : "Nouveau"),
                    avatar: Icon(
                      provider.sortAscending ? Icons.arrow_upward : Icons.arrow_downward,
                      size: 16,
                    ),
                    onPressed: () {
                      context.read<ArticleProvider>().toggleSortOrder();
                    },
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
      body: Column(
        children: [
          Expanded(
            child: provider.isLoading? const Center(child: CircularProgressIndicator()): provider.articles.isEmpty
            ? const Center(child: Text("Aucun article ne correspond.")): ListView.builder(
                itemCount: provider.articles.length,
                itemBuilder: (context, index) {
                  final article = provider.articles[index];
                  return ArticleTile(article: article);
                },
              ),
          ),
        ],
      ),
    );
  }
}