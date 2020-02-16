<?php

declare(strict_types=1);

namespace Shogi\Command;

use Shogi\CliPrintableSpot;
use Shogi\Game;
use Shogi\Spot;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class GameCommand extends Command
{
    private const COMMANDS = ['quit'];

    protected static $defaultName = 'play:shogi';
    private OutputInterface $output;
    private Game $game;

    protected function configure()
    {
        $this->game = new Game;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $outputStyle1 = new OutputFormatterStyle('black', 'white', ['bold']);
        $outputStyle2 = new OutputFormatterStyle('white', 'blue', ['bold']);
        $outputStyle3 = new OutputFormatterStyle('black', 'yellow', ['bold', 'blink']);

        $output->getFormatter()->setStyle('white-piece', $outputStyle1);
        $output->getFormatter()->setStyle('black-piece', $outputStyle2);
        $output->getFormatter()->setStyle('illegal-move', $outputStyle3);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $helper = $this->getHelper('question');

        $output->writeln('Enter moves using notation: from x to');
        $output->writeln('For example: C1xD1');

        do {
            $this->draw();

            $question = new Question(sprintf('<question>Turn for %s. Enter move:</question> ', $this->game->currentPlayer()));

            $nextMove = $helper->ask($input, $output, $question);
            if ($nextMove) {
                $command = array_search($nextMove, self::COMMANDS);
                if (false === $command) {
                    try {
                        $this->game->currentPlayerMove($nextMove);
                    } catch (\Throwable $exception) {
                        $this->output->writeln(sprintf('<illegal-move>%s</>', $exception->getMessage()));
                    }
                }
            }
        } while (!$this->game->hasEnded() && $nextMove !== 'quit');

        return 0;
    }

    private function draw(): void
    {
        $this->drawBoard();
        $this->drawResults();
    }

    private function arrayDecorator(array $array, $tag = 'info'): array
    {
        return array_map(function($item) use ($tag) {
            return sprintf('<%s>%s</>', $tag, $item);
        }, $array);
    }

    private function drawBoard()
    {
        $letters = $this->arrayDecorator(range('a', 'i'));
        $numbers = $this->arrayDecorator(range(9, 1));

        $table = new Table($this->output);
        $table->setHeaders([$numbers]);

        $positions = $this->game->positions();
        foreach ($positions as $i => $line) {
            $line = array_map(function(Spot $spot) {
                return new CliPrintableSpot($spot);
            }, $line);

            $table->addRow(array_merge($line, [$letters[$i]]));

            if ($i < count($positions) - 1) {
                $table->addRow(new TableSeparator());
            }
        }

        $table->render();
    }

    private function drawResults()
    {
        $table = new Table($this->output);
        $table->setStyle('box-double');

        $table->addRows($this->game->moves()->toArray());

        $table->render();
    }
}