<?php

declare(strict_types=1);

namespace Shogi\Command;

use Shogi\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

final class GameCommand extends Command
{
    protected static $defaultName = 'play:shogi';
    private OutputInterface $output;

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $helper = $this->getHelper('question');

        $output->writeln('Enter moves using notation: from x to');
        $output->writeln('For example: C1xD1');

        $game = new Game();

        $this->drawBoard($game->positions());

        do {
            $output->writeln(sprintf('Turn for %s', $game->currentPlayer()));

            $question = new Question('Enter move: ');
            $nextMove = $helper->ask($input, $output, $question);

            $game->currentPlayerMove($nextMove);

            $this->drawBoard($game->positions());
        } while (!$game->isEnded());

        return 0;
    }

    private function drawBoard($positions)
    {
        $letters = range('a', 'i');

        $table = new Table($this->output);
        $table->addRow(range(9, 1));
        $table->addRow(new TableSeparator());

        $counter = 0;
        foreach ($positions as $line) {
            $table->addRow(array_merge($line, [$letters[$counter]]));

            $counter++;

            if ($counter < count($positions)) {
                $table->addRow(new TableSeparator());
            }
        }

        $table->render();

        $this->output->writeln('');
    }
}