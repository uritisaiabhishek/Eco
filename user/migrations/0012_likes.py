# Generated by Django 4.0.6 on 2022-08-08 17:59

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('user', '0011_post_likes'),
    ]

    operations = [
        migrations.CreateModel(
            name='Likes',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
            ],
        ),
    ]