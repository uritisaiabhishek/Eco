# Generated by Django 4.0.1 on 2022-07-16 17:47

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('account', '0002_post_date'),
    ]

    operations = [
        migrations.DeleteModel(
            name='Post',
        ),
    ]